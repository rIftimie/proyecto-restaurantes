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

// #[IsGranted('ROLE_USER')]
#[Route('/api')]
class ApiController extends AbstractController
{
    // Devuelve pedidos asociados al restaurante del usuario
    #[Route('/orders', name: 'app_api_orders_index', methods:["GET"])]
    public function ordersIndex(ApiFormatter $formatter, OrdersRepository $orderRepository, UserInterface $user): JsonResponse
    {
        $orders = $orderRepository->findBy(['restaurant' => $user->getRestaurant()->getId()]);
        $ordersJSON = [];

        foreach($orders as $order) {
            $ordersJSON[] = $formatter->orderToArray($order);
        }
        return new JsonResponse(array_reverse($ordersJSON));
    }

    // Devuelve un pedido
    #[Route('/orders/{id}', name: 'app_api_orders_show', methods:["GET"])]
    public function ordersShow(ApiFormatter $formatter, OrdersRepository $orderRepository, Orders $order): JsonResponse
    {
        if($order){
            $orderJSON = $formatter->orderToArray($order);
        }
        return new JsonResponse($orderJSON);
    }

    // Devuelve el menu del restaurante del usuario
    #[Route('/menu', name: 'app_api_menu')]
    public function menu(ApiFormatter $formatter, RestaurantRepository $restaurantRepository, UserInterface $user): JsonResponse
    {
        $menus = $restaurantRepository->find($user->getRestaurant()->getId())->getMenus();
        $menusJSON = [];

        foreach($menus as $menu){
            $menusJSON[] = $formatter->menuToArray($menu);
        }

        return new JsonResponse($menusJSON);
    }

    // Devuelve el restaurante del usuario
    #[Route('/restaurant', name: 'app_api_restaurant')]
    public function restaurant(ApiFormatter $formatter, RestaurantRepository $restaurantRepository, UserInterface $user): Response
    {
        $restaurant = $restaurantRepository->find($user->getRestaurant()->getId());

        if($restaurant){
            $restaurantJSON= $formatter->restaurantToArray($restaurant);
        }

        return new JsonResponse($restaurantJSON);
    }

    // Devuelve todos los restaurantes
    #[Route('/restaurant/all', name: 'app_api_restaurant_index')]
    public function restaurantIndex(ApiFormatter $formatter, RestaurantRepository $restaurantRepository): Response
    {
        $restaurants  = $restaurantRepository->findAll();
        $restaurantsJSON = [];

        foreach($restaurants as $restaurant) {
            $restaurantsJSON[] = $formatter->restaurantToArray($restaurant);
        }

        return new JsonResponse($restaurantsJSON);
    }

    // Devuelve un restaurante.
    #[Route('/restaurant/{id}', name: 'app_api_restaurant_show')]
    public function restaurantShow(ApiFormatter $formatter, MenuRepository $menuRepository, Restaurant $restaurant): Response
    {
        if($restaurant){
            $restaurantJSON = $formatter->restaurantToArray($restaurant);
        }

        return new JsonResponse($restaurantJSON);
    }

    // Devuelve el menu de un restaurante.
    #[Route('/restaurant/{id}/menu', name: 'app_api_restaurant_menu')]
    public function restaurantMenu(ApiFormatter $formatter, MenuRepository $menuRepository, $id): Response
    {
        $menus = $menuRepository->findBy(["restaurant" => $id]);
        $menusJSON = [];

        foreach($menus as $menu) {
            $menusJSON[] = $formatter->menuToArray($menu);
        }

        return new JsonResponse($menusJSON);
    }

    // Devuelve los pedidos de un restaurante
    #[Route('/restaurant/{id}/orders', name: 'app_api_restaurant_orders')]
    public function restaurantOrders(ApiFormatter $formatter, OrdersRepository $ordersRepository, $id): Response
    {
        $orders = $ordersRepository->findBy(["restaurant" => $id]);
        $ordersJSON = [];

        foreach($orders as $order) {
            $ordersJSON[] = $formatter->orderToArray($order);
        }
        return new JsonResponse($ordersJSON);
    }
}
