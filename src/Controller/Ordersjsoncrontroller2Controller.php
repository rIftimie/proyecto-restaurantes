<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrdersRepository;
//RestaurantRepository
use App\Repository\RestaurantRepository;

use App\Entity\Orders;
use Symfony\Component\HttpFoundation\JsonResponse;


class Ordersjsoncrontroller2Controller extends AbstractController
{
 //   #[Route('/ordersjsoncrontroller2', name: 'app_ordersjsoncrontroller2')]
   /*
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
            'camarero'=>   $order->getWaiter(),
            'Productos'=>$order->getOrderProducts()
            //Get order productos presenta la dificultad de que precisa ser recorrida
         
            );

        }
            return new JsonResponse($ordersJSON);

    }
    */





   // #[Route('/restaurantjsoncrontroller2', name: 'app_restjson')]
    public function index(RestaurantRepository $restrepo): Response
    {
        $allmyrestaurants  = $restrepo->findAll();
        $restaurantsJSON = [];
        foreach($allmyrestaurants  as $myrestaurant) {
            $menus = [];
            $orders = [];
            $users = [];

            foreach ($myrestaurant->getMenus()as $restaurantMenu) {
                //Restaurant Menu Productos
                $obj1 = new \stdClass();
                $obj1 -> menuproducts = $restaurantMenu->getProduct()->getName();
                $menus[]=($obj1);

                
            }
            //Restaurant-Orders

            foreach ($myrestaurant->getOrders() as $restaurantOrders) {
                //Restaurant Menu Productos
                $obj2 = new \stdClass();
                $obj2 -> orders = $restaurantOrders->getId();
                $obj2 -> orders = $restaurantOrders->getOrderDate();
                $orders[]=($obj2);
            }
    //Restaurant-user

    foreach ($myrestaurant->getUsers() as $restaurantUsers) {
        //Restaurant Menu Productos
        $obj3 = new \stdClass();
        $obj3 -> user = $restaurantUsers->getUsername();
       //X ID  $obj3 -> user = $restaurantUsers->getId();

        //$obj3 -> orders = $restaurantOrders->getOrderDate();
        $users[]=($obj3);
    }




            $restaurantsJSON[] = array(
            'id'=>$myrestaurant->getId(),
            'name' => $myrestaurant->getName(),
            'address'=>$myrestaurant->getAddress(),
            'postal code '=>$myrestaurant->getPostalCode(),
            'users'=>$users,
            'orders '=>$orders,
            'menus'=> $menus
                
                
            );

        }
            return new JsonResponse($restaurantsJSON );


        /*
        return $this->render('ordersjsoncrontroller2/index.html.twig', [
            'controller_name' => 'Ordersjsoncrontroller2Controller',
        ]);
        */
    }
}
