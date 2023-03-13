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
            $obj -> id = $orderProduct->getProducts()->getId();
            $obj -> name = $orderProduct->getProducts()->getName();
            $obj -> quantity = $orderProduct->getQuantity();
            $obj -> price = round($orderProduct->getProducts()->getPrice(),2);
            $obj -> description = $orderProduct->getProducts()->getDescription();
            $obj -> allergens = $orderProduct->getProducts()->getAllergens();
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

    public function restaurantToArray($restaurant): array
    {
      $restaurantJSON = array(
          'id' => $restaurant->getId(),
          'name' => $restaurant->getName(),
          'address' => $restaurant->getAddress(),
          'postal code' => $restaurant->getPostalCode(),
          'menu' => "http://localhost:8000/api/restaurant/".$restaurant->getId()."/menu",
      );
      return $restaurantJSON;
    }

    public function productToArray($product): array
    {
      $productJSON= array(
        'id'  => $product->getId(),
        'name' => $product->getName(),
        'description' => $product->getDescription(),
        'allergens' => $product->getAllergens(),
        'hidden' => $product->isHidden(),
        'price' => round($product->getPrice(),2),
        'img' => $product->getImg(),
      );

      return $productJSON;
    }

    public function menuToArray($menu): array
    {
      $product = $this->productToArray($menu->getProduct());

      $menuJSON = array(
        'id'  => $menu->getId(),
        'product' => $product,
        'stock' => $menu->getStock(),
        'hidden' => $menu->isHidden(),
      );

      return $menuJSON;
    }
}