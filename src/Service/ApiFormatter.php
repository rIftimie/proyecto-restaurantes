<?php
namespace App\Service;

class ApiFormatter
{
    // Convierte un Orders a un array associativo
    public function orderToArray($order): array
    {
        $orderJSON=[];
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
            'deliveredBy' => $order->getDeliveredBy(),
            'madeBy' => $order->getMadeBy(),
            'orderDate' => $order->getOrderDate(),
            'deliverDate' => $order->getDeliverDate(),
            'table' => $order->getTableOrder()->getNumber(),
        );

        return $orderJSON;
    }
}