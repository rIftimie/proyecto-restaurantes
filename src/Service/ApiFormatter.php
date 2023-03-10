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
        if($order->getWaiter()){
          $waiter= $order->getWaiter()->getUserName();
        }else{
          $waiter= '';
        }
        $orderJSON = array(
            'id'=> $order->getId(),
            'note' => $order->getNote(),
            'status' => $order->getStatus(),
            'products'=> $products,
            'waiter' => $waiter,
            'orderDate' => $order->getOrderDate(),
            'deliverDate' => $order->getDeliverDate(),
            'table' => $order->getTableOrder()->getNumber(),
        );

        return $orderJSON;
    }
}