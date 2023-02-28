<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\OrdersRepository;
use App\Entity\Orders;
use Symfony\Component\HttpFoundation\JsonResponse;


class Ordersjsoncrontroller2Controller extends AbstractController
{
    #[Route('/ordersjsoncrontroller2', name: 'app_ordersjsoncrontroller2')]
    public function index(OrdersRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        $ordersJSON = [];
        foreach($orders as $order) {
        
            $ordersJSON[] = array(
            'id'=>$order->getId(),
            'estado' => $order->getStatus(),
            'FechaOrder' => $order->getOrderDate(),
            'FechaEntrega' =>    $order->getDeliverDate(),
            'camarero'=>   $order->getWaiter()
            //'Producos'=>getOrderProducts()
            //Get productos es una array
         
            );

        }
            return new JsonResponse($ordersJSON);


        /*
        return $this->render('ordersjsoncrontroller2/index.html.twig', [
            'controller_name' => 'Ordersjsoncrontroller2Controller',
        ]);
        */
    }
    
}
