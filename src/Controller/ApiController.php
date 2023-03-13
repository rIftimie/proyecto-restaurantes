<?php

namespace App\Controller;

use App\Service\ApiFormatter;
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
use App\Entity\Restaurant;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/api')]
class ApiController extends AbstractController
{
    // Devuelve pedidos asociados al restaurante del usuario
    #[Route('/orders', name: 'app_api_orders_index', methods:["GET", "POST"])]
    public function ordersIndex(Request $request, ApiFormatter $apiFormatter, OrdersRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findBy(['restaurant' => $request->getContent()]);
        $ordersJSON = [];

        foreach($orders as $order) {
            $ordersJSON[] = $apiFormatter->orderToArray($order);
        }
        return new JsonResponse(array_reverse($ordersJSON));
    }

    // Devuelve un pedido
    #[Route('/orders/{id}', name: 'app_api_orders_show', methods:["GET"])]
    public function ordersShow(ApiFormatter $apiFormatter, OrdersRepository $orderRepository, Orders $order): JsonResponse
    {
        if($order){
            $orderJSON = $apiFormatter->orderToArray($order);
        }
        return new JsonResponse($orderJSON);
    }
    // Devuelve los productos de la cadena de restaurante
    #[Route('/products', name: 'app_api_products_index', methods:["GET"])]
    public function productsIndex(ApiFormatter $apiFormatter, ProductsRepository $productsRepository): JsonResponse
    {
        $products = $productsRepository->findAll();
        $productsJSON= [];
        
        foreach ($products as $product) {
            $productsJSON [] = $apiFormatter->productToArray($product);
        }
        return new JsonResponse($productsJSON);
    }

    // Devuelve el menu del restaurante del usuario
    #[Route('/menu', name: 'app_api_menu', methods: ["GET", "POST"])]
    public function menu(Request $request, ApiFormatter $apiFormatter, RestaurantRepository $restaurantRepository): JsonResponse
    {
        $menus = $restaurantRepository->find($request->getContent())->getMenus();
        $menusJSON = [];

        foreach($menus as $menu){
            $menusJSON[] = $apiFormatter->menuToArray($menu);
        }

        return new JsonResponse($menusJSON);
    }

    // Devuelve el restaurante del usuario
    #[Route('/restaurant', name: 'app_api_restaurant', methods: ["GET", "POST"])]
    public function restaurant(ApiFormatter $apiFormatter, RestaurantRepository $restaurantRepository): Response
    {
        $restaurant = $restaurantRepository->find($request->getContent());

        if($restaurant){
            $restaurantJSON= $apiFormatter->restaurantToArray($restaurant);
        }

        return new JsonResponse($restaurantJSON);
    }

    // Devuelve todos los restaurantes
    #[Route('/restaurant/all', name: 'app_api_restaurant_index')]
    public function restaurantIndex(ApiFormatter $apiFormatter, RestaurantRepository $restaurantRepository): Response
    {
        $restaurants  = $restaurantRepository->findAll();
        $restaurantsJSON = [];

        foreach($restaurants as $restaurant) {
            $restaurantsJSON[] = $apiFormatter->restaurantToArray($restaurant);
        }

        return new JsonResponse($restaurantsJSON);
    }

    // Devuelve un restaurante.
    #[Route('/restaurant/{id}', name: 'app_api_restaurant_show')]
    public function restaurantShow(ApiFormatter $apiFormatter, MenuRepository $menuRepository, Restaurant $restaurant): Response
    {
        if($restaurant){
            $restaurantJSON = $apiFormatter->restaurantToArray($restaurant);
        }

        return new JsonResponse($restaurantJSON);
    }

    // Devuelve el menu de un restaurante.
    #[Route('/restaurant/{id}/menu', name: 'app_api_restaurant_menu')]
    public function restaurantMenu(ApiFormatter $apiFormatter, MenuRepository $menuRepository, $id): Response
    {
        $menus = $menuRepository->findBy(["restaurant" => $id]);
        $menusJSON = [];

        foreach($menus as $menu) {
            $menusJSON[] = $apiFormatter->menuToArray($menu);
        }

        return new JsonResponse($menusJSON);
    }

    // Devuelve los pedidos de un restaurante
    #[Route('/restaurant/{id}/orders', name: 'app_api_restaurant_orders')]
    public function restaurantOrders(ApiFormatter $apiFormatter, OrdersRepository $ordersRepository, $id): Response
    {
        $orders = $ordersRepository->findBy(["restaurant" => $id]);
        $ordersJSON = [];

        foreach($orders as $order) {
            $ordersJSON[] = $apiFormatter->orderToArray($order);
        }
        return new JsonResponse($ordersJSON);
    }
}
