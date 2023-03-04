<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantsjsonController extends AbstractController
{
    #[Route('/restaurantsjson', name: 'app_restaurantsjson')]
    public function index(): Response
    {
        return $this->render('restaurantsjson/index.html.twig', [
            'controller_name' => 'RestaurantsjsonController',
        ]);
    }
}
