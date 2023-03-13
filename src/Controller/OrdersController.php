<?php

namespace App\Controller;

use App\Entity\OrderProducts;
use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\MenuRepository;
use App\Repository\OrderProductsRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductsRepository;
use App\Repository\RestaurantRepository;
use App\Repository\TableRepository;
use App\Repository\UserRepository;
use App\Service\ApiFormatter;
use App\Service\MercureGenerator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/orders')]
class OrdersController extends AbstractController
{
    #[Route('/', name: 'app_orders_index', methods: ['GET'])]
    public function index(OrdersRepository $ordersRepository): Response
    {   
        return $this->render('orders/index.html.twig', [
            'orders' => $ordersRepository->findAll(),
        ]);
    }

    // Renderiza la vista de camarero
    #[IsGranted('ROLE_USER')]
    #[Route('/waiter', name: 'app_orders_waiter', methods: ['GET'])]
    public function waiter(ApiFormatter $apiFormatter): Response
    {
        return $this->render('waiter/index.html.twig', ['user' => $apiFormatter->userToArray($this->getUser())] );
    }

    // Renderiza la vista de cocina
    #[IsGranted('ROLE_USER')]
    #[Route('/kitchen', name: 'app_orders_kitchen', methods: ['GET'])]
        public function kitchen(ApiFormatter $apiFormatter): Response
    {
        return $this->render('kitchen/index.html.twig', ['user' => $apiFormatter->userToArray($this->getUser())] );
    }

    // 
    #[Route('/add', name: 'app_orders_add', methods: ['POST', 'GET'])]
    public function add(Request $request, RestaurantRepository $restaurantRepository, TableRepository $tableRepository , OrdersRepository $ordersRepository, ProductsRepository $productsRepository, EntityManagerInterface $entityManager): Response
    {
      $order= new Orders();

      $order->setRestaurant($restaurantRepository->findOneById($request->toArray()[0]['restaurant_id']));
      $order->setTableOrder($tableRepository->findOneById($request->toArray()[0]['table_order_id']));
      $order->setStatus(null);
      $order->setOrderDate(new DateTime());

      $orderProds= $request->toArray();

      foreach($orderProds as $product){
        $orderProduct= new OrderProducts();
        $orderProduct->setProducts($productsRepository->findOneById($product['products_id']));
        $orderProduct->setQuantity($product['quantity']);
        $orderProduct->setTotalPrice($productsRepository->findOneById($product['products_id'])->getPrice()*$prod['quantity']);
        $order->addOrderProduct($orderProduct);
        $entityManager->persist($orderProduct);
      }
      
      $entityManager->persist($order);
      $entityManager->flush();

      $response = new Response();
      $productJson=[];
      $products=[];

      foreach($order->getOrderProducts() as $product){
        $products[]=array(
          'id' => $product->getId(),
          'products_id'=>$product->getProducts()->getId(),
          'quantity' => $product->getQuantity(),
          'information' => $product->getInformation(),
          'hidden' => $product->isHidden(),
          'totalPrice' => round($product->getTotalPrice(),2),
        );
      }

      $productJson[]=array(
        'id'=>$order->getId(),
        'restaurant_id'=>$order->getRestaurant()->getId(),
        'table_order_id'=>$order->getTableOrder()->getId(),
        'status'=>$order->getStatus(),
        'order_date'=>$order->getOrderDate(),
        'deliver_date'=>$order->getDeliverDate(),
        'note'=>$order->getNote(),
        'hidden'=>$order->isHidden(),
        'products'=> $products
      );
      $response->setContent(json_encode($productJson));

      return $response;
    }


    #[Route('/{id}/pay', name: 'app_orders_pay', methods: ['GET','POST'])]
    public function pay(OrderProductsRepository $orderProductsRepository ,ApiFormatter $apiFormatter , Request $request ,Orders $ord,EntityManagerInterface $entityManager, ProductsRepository $productsRepository): Response
    {
      if($request->isMethod('post')){
        $realProducts = $request->toArray()['orderProducts'];

        foreach($realProducts as $prod){
          $ordprod= $orderProductsRepository->getProductsByOrderAndProd($ord->getId(),$prod['products_id'])[0];
          $ordprod->setProducts($productsRepository->findOneById($prod['products_id']));
          $ordprod->setQuantity($prod['quantity']);
          $ordprod->setTotalPrice($prod['price']*$prod['quantity']);
          $entityManager->persist($ordprod);
          $entityManager->flush();
        }

        $stripe = new \Stripe\StripeClient(
          $_ENV["STRIPE_SECRET"],
        );

        $stripe->paymentIntents->create([
          "amount" => $request->toArray()['amount'],
          "currency" => "eur",
          "description" => $request->toArray()['description'],
          "payment_method"=>$request->toArray()['id'],
          "confirm" => true
        ]);

        $ord->setStatus(1);
        $entityManager->persist($ord);
        $entityManager->flush();

        return new Response(true);
      }else{
        $order = $apiFormatter->orderToArray($ord);;

        return $this->render('orders/pay.html.twig', [
            'order_id' => $ord->getId(),
            'orderProds'=>$order['products'],
            'stripe_key' => $_ENV["STRIPE_KEY"],
        ]);
      }
    }

    #[Route('/{id}', name: 'app_orders_show', methods: ['GET'])]
    public function show(Request $request, Orders $order, OrdersRepository $ordersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $ordersRepository->remove($order, true);
        }

        return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
    }

    // Vista para el el pedido del cliente.
    #[Route('/{id}/watch', name: 'app_orders_watch', methods: ['GET'])]
    public function watch( ApiFormatter $apiFormatter , MercureGenerator $mercure, Orders $order , EntityManagerInterface $entityManager): Response
    {
      if(!$order->getStatus()){
        $order->setStatus(0);
        $entityManager->flush();
        $mercure->publish($order);
      }

      return $this->render('orders/watch.html.twig', [
        'order' => $apiFormatter->orderToArray($order),
      ]);
    }
    
    // Vista para la creacion de un nuevo pedido con parametros restaurante/mesa
    #[Route('/new/{idres}/{idtable}', name: 'app_orders_new', methods: ['GET', 'POST'])]
    public function new(ApiFormatter $apiFormatter , MenuRepository $menuRepository ,RestaurantRepository $restaurantRepository, TableRepository $tableRepository, $idres, $idtable): Response
    {
      $restaurant = $restaurantRepository->findOneById($idres);
      $table= $tableRepository->findOneById($idtable);
      $menu=[];
      foreach($menuRepository->findBy(['restaurant'=> $res->getId()]) as $m){
        $menu[]=$apiFormatter->menuToArray($m);
      }
      return $this->render('orders/new.html.twig', [
          'idrestaurant' => $restaurant ->getId(),
          'idtable' => $table->getId(),
          'menu' => $menu
      ]);
    }

    // Cocina: termina un pedido.
    #[Route('/kitchen/{id}/finish', name: 'app_orders_kitchen_finish', methods: ['POST'])]
    public function kitchenFinish(Request $request, MercureGenerator $mercure, Orders $order, UserRepository $userRepository, OrdersRepository $ordersRepository) : Response
    {
      $userId = $request->getContent();
      if($user = $userRepository->find($userId)){
        if($order->getStatus()==1){
          $order->setStatus(2);
          $order->setMadeBy($user);
          $ordersRepository->save($order,true);
  
          // Mercure publica una actualizacion
          $mercure->publish($order);

          return new Response('Pedido terminado', Response::HTTP_OK);
        }
      }
      
      return new Response(null, 500);
    }

    // Cocina: cancela un pedido
    #[Route('/kitchen/{id}/decline', name: 'app_orders_kitchen_decline', methods: ['PUT'])]
    public function kitchenDecline(MercureGenerator $mercure, Request $request, Orders $order, OrdersRepository $ordersRepository, MenuRepository $menuRepository) : Response
    {
      $order->setStatus(4);
      foreach($order->getOrderProducts() as $orderProduct){
          foreach($menuRepository->findByRestaurantANDProduct($order->getRestaurant(),$orderProduct->getProducts()->getId()) as $menuFound){
              $menuFound->setStock($menuFound->getStock()+$orderProduct->getQuantity());
              $menuRepository->save($menuFound, true);
          }
      }
      
      $ordersRepository->save($order, true);

      // Mercure publica una actualizacion
      $mercure->publish($order);
      
      return new Response('Pedido cancelado', Response::HTTP_OK);
    }

    // Camarero: cobra en efectivo al cliente.
    #[Route('/waiter/{id}/payWaiter', name: 'app_orders_waiter_payWaiter')]
    public function waiterPay(MercureGenerator $mercure, OrdersRepository $orderRepository, Orders $order): Response
    {
      if (!$order) {
          return new Response('El pedido no existe', Response::HTTP_NOT_FOUND);
      }

      $order->setStatus(1);
      $order->setPayment("cash");
      $orderRepository->save($order, true);
      
      // Mercure publica una actualizacion
      $mercure->publish($order);

      return new Response('Pedido pagado en efectivo', Response::HTTP_OK);
    }

    // Camarero: entrega el pedido al cliente.
    #[Route('/waiter/{id}/deliver', name: 'app_orders_waiter_deliver')]
    public function waiterDeliver(Request $request, MercureGenerator $mercure, UserRepository $userRepository, OrdersRepository $orderRepository, Orders $order): Response
    {
      $userId = $request->getContent();

      if($order && $user = $userRepository->find($userId)){
        $order->setStatus(3);
        $order->setDeliveredBy($user);
        $order->setDeliverDate(new DateTime());
        $orderRepository->save($order, true);
        
        // Mercure publica una actualizacion
        $mercure->publish($order);

        return new Response('Pedido entregado', Response::HTTP_OK);
      }

      return new Response('El pedido no existe', Response::HTTP_NOT_FOUND);

    }

    #[Route('/{id}/edit', name: 'app_orders_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orders $order, OrdersRepository $ordersRepository): Response
    {
        
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordersRepository->save($order, true);

            return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orders/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orders_delete', methods: ['POST'])]
    public function delete(Request $request, Orders $order, OrdersRepository $ordersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $ordersRepository->remove($order, true);
        }

        return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
    }
}