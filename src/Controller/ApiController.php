<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\OrdersRepository;
use App\Entity\Orders;


#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/orders', name: 'app_api_orders')]
    public function indexOrders(OrdersRepository $orderRepository): Response
    {
        $orders = $orderRepository->findBy(['restaurant' => $this->getUser()->getRestaurant()->getId()]);
        
        $ordersJSON = [];

        foreach($orders as $order) {
            $products = [];

            foreach ($order->getOrderProducts() as $orderProduct) {

                $obj = new \stdClass();
                $obj -> name = $orderProduct->getProducts()->getName();
                $obj -> quantity = $orderProduct->getQuantity();

                $products[]=($obj);
            }

            $ordersJSON[] = array(
                'id'=> $order->getId(),
                'note' => $order->getNote(),
                'status'=> $order->getStatus(),
                'products'=> $products,
                'waiter' => $order->getWaiter()->getUserName(),
                'orderDate' => $order->getOrderDate(),
                'deliverDate' => $order->getDeliverDate(),
                'table' => $order->getTableOrder()->getNumber(),
            );
        }

        return new JsonResponse($ordersJSON);
    }

    #[Route('/orders/{id}', name: 'app_api_order_individual')]
    public function indexOrder(OrdersRepository $orderRepository, Request $request): Response
    {
        $order = $orderRepository->findOneByID($request->get('id'));

        $products = [];

        foreach ($order->getOrderProducts() as $orderProduct) {

            $obj = new \stdClass();
            $obj -> name = $orderProduct->getProducts()->getName();
            $obj -> quantity = $orderProduct->getQuantity();

            $products[]=($obj);
        }

        $orderJSON = [];
        $orderJSON[] = array(
            'id'=> $order->getId(),
            'note' => $order->getNote(),
            'status' => $order->getStatus(),
            'products'=> $products,
            'waiter' => $order->getWaiter()->getUserName(),
            'orderDate' => $order->getOrderDate(),
            'deliverDate' => $order->getDeliverDate(),
            'table' => $order->getTableOrder()->getNumber(),
        );


        return new JsonResponse($orderJSON);
    }
}
