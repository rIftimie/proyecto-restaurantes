<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Orders;
use App\Form\OrdersType;
use App\Repository\MenuRepository;
use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('kitchen/index.html.twig');
    }

    #[Route('/new', name: 'app_orders_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrdersRepository $ordersRepository): Response
    {
        $order = new Orders();
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

    #[Route('/kitchen/{id}/finish', name: 'app_orders_kitchen_finish', methods: ['PUT'])]
    public function kitchenFinish(Request $request, Orders $order, OrdersRepository $ordersRepository) : Response
    {
        $order->setStatus(3);
        $ordersRepository->save($order,true);
        return $this->render('kitchen/index.html.twig',[]);
    }

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

    #[Route('/{id}/paidWaiter', name: 'app_orders_paidWaiter')]
    public function payCash(OrdersRepository $orderRepository, Orders $order): Response
    {

        if (!$order) {
            // El recurso no existe
            return new Response('El pedido no existe', Response::HTTP_NOT_FOUND);
        }
    
        $order->setStatus(1);
        $orderRepository->save($order, true);
    
        return new Response('Pedido pagado en efectivo', Response::HTTP_OK);
    }

    #[Route('/{id}/delivered', name: 'app_orders_delivered')]
    public function delivered(OrdersRepository $orderRepository, Orders $order): Response
    {

        if (!$order) {
            // El recurso no existe
            return new Response('El pedido no existe', Response::HTTP_NOT_FOUND);
        }
    
        $order->setStatus(4);
        $orderRepository->save($order, true);
    
        return new Response('Pedido entregado', Response::HTTP_OK);
    }
    
}
//  0 -> pending    
//  1 -> payed    
//  2 -> process    
//  3 -> ready 
//  4 -> delivered
//  5 -> cancelled

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