<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
        $orders = $orderRepository->findAll();

        $ordersJSON = [];

        foreach($orders as $order) {
            $ordersJSON[] = array(
                'id'=> $order->getId(),
                'name' => $order->getName(),
            );
        }

        return new JsonResponse($ordersJSON);
    }
}
