<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\OrdersRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/user', name: 'app_user')]
    public function getUsers(UserRepository $userRepository): Response
    {
      
        $users = $userRepository->findAll();
        
        $usersJSON = [];

        foreach ($users as $user) {

            $usersJSON[] = array(

                'id'=> $user->getId(),
                'username' => $user->getUsername(),
                'roles'=> $user->getRoles(),

            );
        
        }
        return new JsonResponse($usersJSON);
    }

    #[Route('/orders', name: 'app_orders')]
    public function getOrders(OrdersRepository $ordersRepository): Response
    {
      
        $orders = $ordersRepository->findAll();
        
        $ordersJSON = [];

        foreach ($orders as $order) {

            $ordersJSON[] = array(

                'id'=> $order->getId(),
                'status' => $order->getStatus(),
                'order_date' => $order->getOrderDate(),
                'note' => $order->getNote(),

            );
        
        }
        return new JsonResponse($ordersJSON);
    }
}
