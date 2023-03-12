<?php

namespace App\Controller;

use App\Entity\OrderProducts;
use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\MenuRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductsRepository;
use App\Repository\RestaurantRepository;
use App\Repository\TableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MercureGenerator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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

    #[Route('/add', name: 'app_orders_add', methods: ['POST', 'GET'])]
    public function add(Request $request, RestaurantRepository $resRep, TableRepository $tabRep , OrdersRepository $ordersRepository, ProductsRepository $prodRep, EntityManagerInterface $entityManager): Response
    {
      $miOrder= new Orders();
      $miOrder->setRestaurant($resRep->findOneById($request->toArray()[0]['restaurant_id']));
      $miOrder->setTableOrder($tabRep->findOneById($request->toArray()[0]['table_order_id']));
      $miOrder->setStatus(null);
      $miOrder->setOrderDate(new DateTime());
      $orderProds= $request->toArray();
      foreach($orderProds as $prod){
        $orderProduct= new OrderProducts();
        $orderProduct->setProducts($prodRep->findOneById($prod['products_id']));
        $orderProduct->setQuantity($prod['quantity']);
        $orderProduct->setTotalPrice($prodRep->findOneById($prod['products_id'])->getPrice()*$prod['quantity']);
        $miOrder->addOrderProduct($orderProduct);
        $entityManager->persist($orderProduct);
      }
      
      $entityManager->persist($miOrder);
      $entityManager->flush();
      $resp = new Response();
      $productJson=[];
      $allProducts=[];

      foreach($miOrder->getOrderProducts() as $prod){
        $allProducts[]=array(
          'id' => $prod->getId(),
          'products_id'=>$prod->getProducts()->getId(),
          'quantity' => $prod->getQuantity(),
          'information' => $prod->getInformation(),
          'hidden' => $prod->isHidden(),
          'totalPrice' => round($prod->getTotalPrice(),2),
        );
      }

      $productJson[]=array(
        'id'=>$miOrder->getId(),
        'restaurant_id'=>$miOrder->getRestaurant()->getId(),
        'table_order_id'=>$miOrder->getTableOrder()->getId(),
        'status'=>$miOrder->getStatus(),
        'order_date'=>$miOrder->getOrderDate(),
        'deliver_date'=>$miOrder->getDeliverDate(),
        'note'=>$miOrder->getNote(),
        'hidden'=>$miOrder->isHidden(),
        'products'=> $allProducts
      );
      $resp->setContent(json_encode($productJson));
      return $resp;
      
    }

    // Renderiza la vista de camarero
    #[Route('/waiter', name: 'app_orders_waiter', methods: ['GET'])]
    public function waiter(): Response
    {
        return $this->render('waiter/index.html.twig');
    }

    // Renderiza la vista de cocina
    #[Route('/kitchen', name: 'app_orders_kitchen', methods: ['GET'])]
        public function kitchen(): Response
    {
        return $this->render('kitchen/index.html.twig' );
    }

    #[Route('/pay/{id}', name: 'app_orders_pay', methods: ['GET'])]
    public function pay(OrdersRepository $orderRepository, ProductsRepository $prodRep ,$id): Response
    {
      $order = $orderRepository->findOneById($id);
      $products=[];
      foreach ($order->getOrderProducts() as $prod){
        $product= $prodRep->findOneById($prod->getProducts()->getId());
        $products[]=array(
          'id'=> $product->getId(),
          'name'=>$product->getName(),
          'description'=>$product->getDescription(),
          'allergens'=>$product->getAllergens(),
          'hidden'=>$product->isHidden(),
          'price'=>round($product->getPrice(),2),
          'img'=>$product->getImg(),
          'quantity'=>$prod->getQuantity(),
        );
      }
        return $this->render('orders/pay.html.twig', [
            // 'order' => $order,
            'order_id' => $id,
            'orderProds'=>$products,
            'stripe_key' => $_ENV["STRIPE_KEY"],
        ]);
    }

    #[Route('/paid', name: 'app_orders_paid', methods: ['POST'])]
    public function paid(Request $request): Response
    {
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
        $this->addFlash(
            'success',
            'Payment Successful!'
        );
        return new Response(true);
    }

    #[Route('/{id}/waiting', name: 'app_orders_waiting', methods: ['GET'])]
    public function waiting( MercureGenerator $mercure, Orders $order, EntityManagerInterface $entityManager): Response
    // Orders $order
    {
      // $order->setStatus(0);
      // $entityManager->persist($order);
      // $entityManager->flush();
      // $mercure->publish($order);
        return $this->render('orders/waiting.html.twig', [
            'orderId' => $order->getId(),
        ]);
    }
    #[Route('/{id}/completed', name: 'app_orders_completed', methods: ['GET'])]
    public function completed( MercureGenerator $mercure, Orders $order, EntityManagerInterface $entityManager): Response
    // Orders $order
    {
      $order->setStatus(1);
      $entityManager->persist($order);
      $entityManager->flush();
      return $this->render('orders/completed.html.twig', [
        'order' => $order->getId(),
      ]);
    }
    
    #[Route('/{id}/update', name: 'app_orders_update', methods: ['PUT'])]
    public function update( MercureGenerator $mercure, Orders $order, EntityManagerInterface $entityManager, Request $request): Response
    // Orders $order
    {
      dd($request->toArray());
      $entityManager->persist($order);
      $entityManager->flush();
      $mercure->publish($order);
        return $this->render('orders/completed.html.twig', [
            // 'order' => $order,
        ]);
    }


    #[Route('/new/{idres}/{idtable}', name: 'app_orders_new', methods: ['GET', 'POST'])]
    public function new(RestaurantRepository $restaurantRepository, TableRepository $tableRepository, $idres, $idtable): Response
    {
      $res= $restaurantRepository->findOneById($idres);
      $table= $tableRepository->findOneById($idtable);

      return $this->render('orders/new.html.twig', [
          'idres' => $res->getId(),
          'idtable' => $table->getId(),
      ]);
    }

    // Cocina: termina un pedido.
    #[Route('/kitchen/{id}/finish', name: 'app_orders_kitchen_finish', methods: ['PUT'])]
    public function kitchenFinish(MercureGenerator $mercure, Request $request, Orders $order, OrdersRepository $ordersRepository, UserInterface $user) : Response
    {
        if($order->getStatus()==1){
            $order->setStatus(2);
            $order->setMadeBy($user);
            $ordersRepository->save($order,true);
    
            // Mercure publica una actualizacion
            $mercure->publish($order);

            return new Response('Pedido terminado', Response::HTTP_OK);
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
            // El recurso no existe
            return new Response('El pedido no existe', Response::HTTP_NOT_FOUND);
        }

        $order->setStatus(1);
        $orderRepository->save($order, true);
        
        // Mercure publica una actualizacion
        $mercure->publish($order);

        return new Response('Pedido pagado en efectivo', Response::HTTP_OK);
    }

    // Camarero: entrega el pedido al cliente.
    #[Route('/waiter/{id}/deliver', name: 'app_orders_waiter_deliver')]
    public function waiterDeliver(MercureGenerator $mercure, OrdersRepository $orderRepository, Orders $order, UserInterface $user): Response
    {
        if (!$order) {
            // El recurso no existe
            return new Response('El pedido no existe', Response::HTTP_NOT_FOUND);
        }
    
        $order->setStatus(3);
        $order->setDeliverBy($user);
        $orderRepository->save($order, true);
        
        // Mercure publica una actualizacion
        $mercure->publish($order);

        return new Response('Pedido entregado', Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_orders_show', methods: ['GET'])]
    public function show(Orders $order): Response
    {
        return $this->render('orders/show.html.twig', [
            'order' => $order,
        ]);
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