<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\{TextField, ChoiceField};
use App\Repository\RestaurantRepository;

class UserCrudController extends AbstractCrudController
{
    private $restaurantRepository;

    public function __construct(RestaurantRepository $restaurantRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('username');
        yield TextField::new('password');
        yield ChoiceField::new('roles')
        ->setChoices([
            'Admin' => 'ROLE_ADMIN',
            'User' => 'ROLE_USER',
            'Super_admin' => 'ROLE_SUPER_ADMIN'
        ])
        ->allowMultipleChoices();
    
        yield ChoiceField::new('restaurant')
            ->setChoices($this->getRestaurantes())
        ->allowMultipleChoices();
    }

    private function getRestaurantes(): array 
    {
        $cont = 0;
        $restaurantes = $this->restaurantRepository->findAll();
        $choices = [];
        foreach ($restaurantes as $restaurante) {
            $choices[$restaurante->getName()] = strval($cont);
            $cont++;
        }
        return $choices;
    }
}
