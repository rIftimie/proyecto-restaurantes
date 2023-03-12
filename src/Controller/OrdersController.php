<?php

namespace App\Controller;

use Stripe;
use App\Entity\Menu;
use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\MenuRepository;
use App\Repository\OrdersRepository;
use App\Controller\ApiController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MercureGenerator;

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

    #[Route('/waiter', name: 'app_orders_waiter', methods: ['GET'])]
    public function waiter(): Response
    {
        return $this->render('waiter/index.html.twig');
    }

    #[Route('/kitchen', name: 'app_orders_kitchen', methods: ['GET'])]
        public function kitchen(): Response
    {
        return $this->render('kitchen/index.html.twig' );
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
        return $this->render('orders/completed.html.twig');
    }

    #[Route('/new/{idres}/{idtable}', name: 'app_orders_new', methods: ['GET', 'POST'])]
    public function new($idres, $idtable): Response
    {
        return $this->render('orders/new.html.twig', [
            'idres' => $idres,
            'idtable' => $idtable,
        ]);
    }

    // Cocina: termina un pedido.
    #[Route('/kitchen/{id}/finish', name: 'app_orders_kitchen_finish', methods: ['PUT'])]
    public function kitchenFinish(MercureGenerator $mercure, Request $request, Orders $order, OrdersRepository $ordersRepository) : Response
    {
        if($order->getStatus()==1){
            $order->setStatus(2);
            $ordersRepository->save($order,true);
    
            // Llama a Mercure
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

        // Llama a Mercure
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
        
        // Llama a Mercure
        $mercure->publish($order);

        return new Response('Pedido pagado en efectivo', Response::HTTP_OK);
    }

    // Camarero: entrega el pedido al cliente.
    #[Route('/waiter/{id}/deliver', name: 'app_orders_waiter_deliver')]
    public function waiterDeliver(MercureGenerator $mercure, OrdersRepository $orderRepository, Orders $order): Response
    {
        if (!$order) {
            // El recurso no existe
            return new Response('El pedido no existe', Response::HTTP_NOT_FOUND);
        }
    
        $order->setStatus(3);
        $order->setWaiter($this->getUser());
        $orderRepository->save($order, true);
        
        // Llama a Mercure
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

//  0 -> pending    
//  1 -> payed    
//  2 -> ready 
//  3 -> delivered
//  4 -> cancelled
