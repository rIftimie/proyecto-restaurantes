<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\OrderProducts;
use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\MenuRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductsRepository;
use App\Repository\RestaurantRepository;
use App\Repository\TableRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe;

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
      $miOrder->setStatus(0);
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
          'totalPrice' => $prod->getTotalPrice(),
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
    #[Route('/waiter', name: 'app_orders_waiter', methods: ['GET'])]
    public function waiter(): Response
    {
        return $this->render('waiter/index.html.twig');
    }

    #[Route('/kitchen', name: 'app_orders_kitchen', methods: ['GET'])]
        public function kitchen(): Response
    {
        return $this->render('kitchen/index.html.twig');
    }
    #[Route('/pay/{id}', name: 'app_orders_pay', methods: ['GET'])]
    public function pay(OrdersRepository $orderRepository, ProductsRepository $prodRep ,$id): Response
    // Orders $order
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
          'price'=>$product->getPrice(),
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
    // Orders $order
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

    #[Route('/completed', name: 'app_orders_completed', methods: ['GET'])]
    public function completed(): Response
    // Orders $order
    {
        return $this->render('orders/completed.html.twig', [
            // 'order' => $order,
        ]);
    }
    
    #[Route('/alter', name: 'app_orders_index_alterada', methods: ['GET'])]
    public function indexalter(OrdersRepository $ordersRepository): Response
    {
        return $this->render('orders/indexalter.html.twig', [
            'orders' => $ordersRepository->findAll(),
        ]);
    }

    #[Route('/new/{idres}/{idtable}', name: 'app_orders_new', methods: ['GET', 'POST'])]
    public function new($idres, $idtable): Response
    {


      return $this->render('orders/new.html.twig', [
          'idres' => $idres,
          'idtable' => $idtable,
      ]);
    }

    // Cocina: acepta un pedido.
    #[Route('/kitchen/{id}/accept', name: 'app_orders_kitchen_accept', methods: ['PUT'])]
    public function kitchenAccept(Request $request, Orders $order, OrdersRepository $ordersRepository, MenuRepository $menuRepository) : Response
    {
        if($order->getStatus()==1){
            $order->setStatus(2);
            foreach($order->getOrderProducts() as $orderProduct){
                foreach($menuRepository->findByRestaurantANDProduct($order->getRestaurant(),$orderProduct->getProducts()->getId()) as $menuFound){
                    $menuFound->setStock($menuFound->getStock()-$orderProduct->getQuantity());
                    $menuRepository->save($menuFound, true);
                }
            }
            $ordersRepository->save($order, true);
        }
        
        return $this->render('kitchen/index.html.twig',[]);
    }

    // Cocina: termina un pedido.
    #[Route('/kitchen/{id}/finish', name: 'app_orders_kitchen_finish', methods: ['PUT'])]
    public function kitchenFinish(Request $request, Orders $order, OrdersRepository $ordersRepository) : Response
    {
        $order->setStatus(3);
        $ordersRepository->save($order,true);
        return $this->render('kitchen/index.html.twig',[]);
    }

    // Cocina: cancela un pedido
    #[Route('/kitchen/{id}/decline', name: 'app_orders_kitchen_decline', methods: ['PUT'])]
    public function kitchenDecline(Request $request, Orders $order, OrdersRepository $ordersRepository, MenuRepository $menuRepository) : Response
    {
        if($order->getStatus()==2){
            $order->setStatus(5);
            foreach($order->getOrderProducts() as $orderProduct){
                foreach($menuRepository->findByRestaurantANDProduct($order->getRestaurant(),$orderProduct->getProducts()->getId()) as $menuFound){
                    $menuFound->setStock($menuFound->getStock()+$orderProduct->getQuantity());
                    $menuRepository->save($menuFound, true);
                }
            }
            $ordersRepository->save($order, true);
        }
        return $this->render('kitchen/index.html.twig',[]);
    }

    // Camarero: cobra en efectivo al cliente.
    #[Route('/waiter/{id}/payWaiter', name: 'app_orders_waiter_payWaiter')]
    public function waiterPay(OrdersRepository $orderRepository, Orders $order): Response
    {
        if (!$order) {
            // El recurso no existe
            return new Response('El pedido no existe', Response::HTTP_NOT_FOUND);
        }

        $order->setStatus(1);
        $orderRepository->save($order, true);
    
        return new Response('Pedido pagado en efectivo', Response::HTTP_OK);
    }

    // Camarero: entrega el pedido al cliente.
    #[Route('/waiter/{id}/deliver', name: 'app_orders_waiter_deliver')]
    public function waiterDeliver(OrdersRepository $orderRepository, Orders $order): Response
    {
        if (!$order) {
            // El recurso no existe
            return new Response('El pedido no existe', Response::HTTP_NOT_FOUND);
        }
    
        $order->setStatus(4);
        $orderRepository->save($order, true);
    
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

//  0 -> pending    
//  1 -> payed    
//  2 -> in progress    
//  3 -> ready 
//  4 -> delivered
//  5 -> cancelled
