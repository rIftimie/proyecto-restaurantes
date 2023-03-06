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
    #[Route('/orders', name: 'app_api_orders_index')]
    public function index(OrdersRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findBy(['restaurant' => $this->getUser()->getRestaurant()->getId()]);
        
        $ordersJSON = [];

        foreach($orders as $order) {
            $ordersJSON[] = $this->toJSON($order);
        }
        return new JsonResponse($ordersJSON);
    }

    #[Route('/orders/{id}', name: 'app_api_order_show')]
    public function show(OrdersRepository $orderRepository, Orders $order): JsonResponse
    {
        if($order){
            $orderJSON = $this->toJSON($order);
        }

        return new JsonResponse($orderJSON);
    }

    public function toJSON($order): array
    {
        $orderJSON;
        $products = [];

        foreach ($order->getOrderProducts() as $orderProduct) {

            $obj = new \stdClass();
            $obj -> name = $orderProduct->getProducts()->getName();
            $obj -> quantity = $orderProduct->getQuantity();

            $products[]=($obj);
        }

        $orderJSON = array(
            'id'=> $order->getId(),
            'note' => $order->getNote(),
            'status' => $order->getStatus(),
            'products'=> $products,
            'waiter' => $order->getWaiter()->getUserName(),
            'orderDate' => $order->getOrderDate(),
            'deliverDate' => $order->getDeliverDate(),
            'table' => $order->getTableOrder()->getNumber(),
        );

        return $orderJSON;
    }
}
