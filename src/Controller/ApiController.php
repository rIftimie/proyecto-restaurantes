<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\OrdersRepository;
use App\Repository\MenuRepository;
use App\Repository\ProductsRepository;
use App\Repository\RestaurantRepository;
use App\Entity\Orders;

#[Route('/api')]
class ApiController extends AbstractController
{
    // Devuelve todos los pedidos asociados con el restaurante del usuario en formato JSON
    #[Route('/orders', name: 'app_api_orders_index', methods:["GET"])]
    public function index(OrdersRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findBy(['restaurant' => $this->getUser()->getRestaurant()->getId()]);
        $ordersJSON = [];

        foreach($orders as $order) {
            $ordersJSON[] = $this->orderToArray($order);
        }
        return new JsonResponse($ordersJSON,Response::HTTP_OK,);
    }

    // Devuelve un pedido en formato JSON
    #[Route('/orders/{id}', name: 'app_api_order_show', methods:["GET"])]
    public function show(OrdersRepository $orderRepository, Orders $order): JsonResponse
    {
        if($order){
            $orderJSON = $this->orderToArray($order);
        }

        return new JsonResponse($orderJSON,Response::HTTP_OK,);
    }

    // Devuelve todos los restaurantes formato JSON
    #[Route('/restaurant', name: 'app_api_restaurant')]
    public function restaurant(RestaurantRepository $restrepo, ProductsRepository $prodrep): Response
    {
        $allmyrestaurants  = $restrepo->findAll();
        $restaurantsJSON = [];
        foreach($allmyrestaurants  as $myrestaurant) {
        $menu = [];
        $orders = [];
        $users = [];

        foreach ($myrestaurant->getMenus()as $restaurantMenu) {
            //Restaurant Menu Productos
            $product= $prodrep->findById($restaurantMenu->getProduct());
            $menu[]=array(
                'id'=>$product[0]->getId(),
                'name' => $product[0]->getName(),
                'description' => $product[0]->getDescription(),
                'allergens' =>    $product[0]->getAllergens(),
                'hidden'=>   $product[0]->isHidden(),
                'price'=>$product[0]->getPrice()
            );
        }
        //Restaurant-Orders
        foreach ($myrestaurant->getOrders() as $restaurantOrders) {
            //Restaurant Menu Productos
            $obj2 = new \stdClass();
            $obj2 -> orders = $restaurantOrders->getId();
            $obj2 -> orders = $restaurantOrders->getOrderDate();
            $orders[]=($obj2);
        }

        //Restaurant-User
        foreach ($myrestaurant->getUsers() as $restaurantUsers) {

        //Restaurant Menu Productos
        $obj3 = new \stdClass();
        $obj3 -> user = $restaurantUsers->getUsername();
        $users[]=($obj3);
        }
            $restaurantsJSON[] = array(
            'id'=>$myrestaurant->getId(),
            'name' => $myrestaurant->getName(),
            'address'=>$myrestaurant->getAddress(),
            'postal code '=>$myrestaurant->getPostalCode(),
            'users'=>$users,
            'orders '=>$orders,
            'menu'=> $menu
            );
        }

        return new JsonResponse($restaurantsJSON );
    }

    // Devuelve el menu de un restaurante formato JSON
    #[Route('/restaurant/{id}/products', name: 'app_api_products')]
    public function products(MenuRepository $menuRepository, ProductsRepository $prodrep, $id): JsonResponse
    {
        $menu = $menuRepository->findBy(['restaurant' => $id]);
        $productsJSON = [];
        foreach($menu as $menuItem){
          $obj = new \stdClass();
          $obj->id=$prodrep->findById($menuItem->getProduct())[0]->getId();
          $obj->name=$prodrep->findById($menuItem->getProduct())[0]->getName();
          $obj->description=$prodrep->findById($menuItem->getProduct())[0]->getDescription();
          $obj->allergens=$prodrep->findById($menuItem->getProduct())[0]->getAllergens();
          $obj->hidden=$prodrep->findById($menuItem->getProduct())[0]->isHidden();
          $obj->price=$prodrep->findById($menuItem->getProduct())[0]->getPrice();
          $obj->img=$prodrep->findById($menuItem->getProduct())[0]->getImg();

          $productsJSON[]= array(
            'id'  => $menuItem->getId(),
            'product' => $obj,
            'stock' => $menuItem->getStock(),
            'hidden' => $menuItem->isHidden(),

          );
        }
        return new JsonResponse($productsJSON);
    }
    
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
            'waiter' => $order->getWaiter()->getUserName(),
            'orderDate' => $order->getOrderDate(),
            'deliverDate' => $order->getDeliverDate(),
            'table' => $order->getTableOrder()->getNumber(),
        );

        return $orderJSON;
    }
}
