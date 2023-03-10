<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\TableRepository;

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
    public function indexUser(UserRepository $userRepository): Response
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
    #[Route('/tables', name: 'app_tables')]
    public function indexTables(TableRepository $tableRepository): Response
    {
      
        $tables = $tableRepository->findAll();
        
        $tablesJSON = [];

        foreach ($tables as $table) {

            $tablesJSON[] = array(
                'id'=> $table->getId(),
                'number' => $table->getNumber(),
                'restaurant' => $table->getRestaurant(),
                'hidden'=> $table->getHidden(),
            );
        
        }
        return new JsonResponse($tablesJSON);
    }
}
