<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\OrdersRepository;
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

    #[Route('/new', name: 'app_orders_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrdersRepository $ordersRepository): Response
    {
        $order = new Orders();
        //MODELO $noticium->setAutor($this->getUser());
    //    $order-> setOrderDate(new \DateTime('now'));
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordersRepository->save($order, true);
            


            return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orders/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }
    
    #[Route('/waiter', name: 'app_orders_waiter', methods: ['GET', 'POST'])]
    public function apiWaiter(Request $request, OrdersRepository $ordersRepository): Response
    {
       
        return $this->render('waiter/index.html.twig', [
            'allOrders' =>  $ordersRepository->findAll(),
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
//  2 -> ready    
//  3 -> delivered    

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