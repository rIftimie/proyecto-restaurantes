<?php

namespace App\Controller;

use App\Entity\OrderProducts;
use App\Entity\Orders;
use App\Form\OrdersType;
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
    #[Route('/pay', name: 'app_orders_pay', methods: ['GET'])]
    public function pay(): Response
    // Orders $order
    {
        return $this->render('orders/pay.html.twig', [
            // 'order' => $order,
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
      $mercure->publish($order);
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

    #[Route('/new', name: 'app_orders_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrdersRepository $ordersRepository): Response
    {
        // $order = new Orders();
        //MODELO $noticium->setAutor($this->getUser());
    //    $order-> setOrderDate(new \DateTime('now'));
        // $form = $this->createForm(OrdersType::class, $order);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $ordersRepository->save($order, true);
            


        //     return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
        // }

        return $this->render('orders/new.html.twig', [
            // 'order' => $order,
            // 'form' => $form,
        ]);
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
//  2 -> working
//  3 -> done
//  4 -> delivered

/*    #[Route('/waiter/pending_orders', name: 'app_pending_orders', methods: ['POST'])]
    public function pendingOrders(Request $request, Orders $order, OrdersRepository $ordersRepository): Response
    {
        return $this->redirectToRoute('app_orders_index', ['pending-orders' => $ordersRepository->findOneByStatus(0), ], Response::HTTP_SEE_OTHER);
    }
    #[Route('/waiter/payed_orders', name: 'app_payed_orders', methods: ['POST'])]
    public function payedOrders(Request $request, Orders $order, OrdersRepository $ordersRepository): Response
    {
        return $this->redirectToRoute('app_orders_index', ['pending-orders' => $ordersRepository->findOneByStatus(1), ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/waiter/ready_orders', name: 'app_ready_orders', methods: ['POST'])]
    public function readyOrders(Request $request, Orders $order, OrdersRepository $ordersRepository): Response
    {
        return $this->redirectToRoute('app_orders_index', ['pending-orders' => $ordersRepository->findOneByStatus(2), ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/waiter/delivered_orders', name: 'app_delivered_orders', methods: ['POST'])]
    public function deliveredOrders(Request $request, Orders $order, OrdersRepository $ordersRepository): Response
    {
        return $this->redirectToRoute('app_orders_index', ['pending-orders' => $ordersRepository->findOneByStatus(3), ], Response::HTTP_SEE_OTHER);
    } */