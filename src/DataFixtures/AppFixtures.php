<?php

namespace App\DataFixtures;

use App\Entity\Orders;
use App\Entity\Products;
use App\Entity\OrderProducts;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Entity\Table;
use App\Entity\Menu;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface) 
    {
        $this->passwordHasher = $userPasswordHasherInterface;
    }
    
    public function load(ObjectManager $manager): void
    {
         // Restaurant 1
         $restaurant1 = new Restaurant();
         $restaurant1->setName("Nacho's Guacamole");
         $restaurant1->setAddress("C/ Camino de Ronda 231º");
         $restaurant1->setPostalCode("18003");
         $manager->persist($restaurant1);
 
         // Restaurant 2
         $restaurant2 = new Restaurant();
         $restaurant2->setName("Nacho's Guacamole");
         $restaurant2->setAddress("C/ Mendez Nunez 2º");
         $restaurant2->setPostalCode("18002");
         $manager->persist($restaurant2);


         // Waiter 1
        $waiter1 = new User();
        $waiter1 -> setUsername("jorgecre175");
        $waiter1 -> setFirstName("Jorge");
        $waiter1 -> setLastName("Cremades");
        $waiter1 -> setRoles(["ROLE_WAITER"]);
        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $this->passwordHasher->hashPassword(
            $waiter1,
            "123456"
        );
        $waiter1->setPassword($hashedPassword);
        $waiter1->setRestaurant($restaurant1);
        $manager->persist($waiter1);

        // Waiter 2
        $waiter2 = new User();
        $waiter2 -> setUsername("carmenroma142");
        $waiter2 -> setFirstName("Carmen");
        $waiter2 -> setLastName("Rodriguez Martin");
        $waiter2 -> setRoles(["ROLE_WAITER"]);
        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $this->passwordHasher->hashPassword(
            $waiter2,
            "123456"
        );
        $waiter2->setPassword($hashedPassword);
        $waiter2->setRestaurant($restaurant2);
        $manager->persist($waiter2);

        // Products : create 5
        $products = [];
        $names = ["hamburguer","pizza","nachos","taco","burrito"];
        $descriptions = ["Classic hamburger with chicken meat, onion and bbq sauce.", "4-Cheese pizza with goat and cow milk.","Nachos with guacamole." ,"Traditional Taco with cow meat.", "Burrito filled with chicken meat and salad."];
        $allergens = [["Gluten", "Lacteos"],["Lacteos"],["Frutos Secos"],["Gluten"],["Gluten", "Lacteos","Huevos"]];
        $stock = [50,23,10,70,99];
        $price = [4.99, 7.80, 1.99,1.49,2];

        // Add products and menu
        for ($i=0; $i <count($names) ; $i++) { 
            $product = new Products();
            $product->setName($names[$i]);
            $product->setDescription($descriptions[$i]);
            $product->setAllergens($allergens[$i]);
            $product->setPrice($price[$i]);

            $menu = new Menu(); 
            $menu->setRestaurant($restaurant1);
            $menu->setProduct($product);
            $menu->setStock($stock[$i]);

            $products[] = $product;
            $manager->persist($product);
            $manager->persist($menu);
        }

        // Tables : create 5
        $table1 = new Table();
        $table1->setNumber(1);
        $table1->setRestaurant($restaurant1);

        $table2 = new Table();
        $table2->setNumber(2);
        $table2->setRestaurant($restaurant1);

        $table3 = new Table();
        $table3->setNumber(3);
        $table3->setRestaurant($restaurant1);

        $table4 = new Table();
        $table4->setNumber(4);
        $table4->setRestaurant($restaurant1);

        $table5 = new Table();
        $table5->setNumber(5);
        $table5->setRestaurant($restaurant1);
        
        $manager->persist($table1);
        $manager->persist($table2);
        $manager->persist($table3);
        $manager->persist($table4);
        $manager->persist($table5);
        

        // Orders : create 4
        // Order1 - pending
        $order1 = new Orders();
        $order1->setStatus(0);
        $order1->setOrderDate(date_create("2023-02-22 12:53"), 'Y-m-d H:i');
        $order1->setWaiter($waiter1);
        $order1->setRestaurant($restaurant1);
        $order1->setTableOrder($table1);
        $manager->persist($order1);

        // Order2 - payed
        $order2 = new Orders();
        $order2->setStatus(1);
        $order2->setOrderDate(date_create("2023-02-22 12:37"), 'Y-m-d H:i');
        $order2->setWaiter($waiter2);
        $order2->setRestaurant($restaurant1);
        $order2->setTableOrder($table1);
        $manager->persist($order2);

        // Order3 - preparing
        $order3 = new Orders();
        $order3->setStatus(2);
        $order3->setOrderDate(date_create("2023-02-23 11:05"), 'Y-m-d H:i');
        $order3->setNote("Extra Jamon");
        $order3->setWaiter($waiter1);
        $order3->setRestaurant($restaurant1);
        $order3->setTableOrder($table2);
        $manager->persist($order3);

        // Order4 - delivered 
        $order4 = new Orders();
        $order4->setStatus(3);
        $order4->setOrderDate(date_create("2023-02-23 13:10"), 'Y-m-d H:i');
        $order4->setDeliverDate(date_create("2023-02-23 13:35"), 'Y-m-d H:i');
        $order4->setWaiter($waiter2);
        $order4->setRestaurant($restaurant1);
        $order4->setTableOrder($table3);
        $manager->persist($order4);


        // OrderProducts : Create 4
        $orderProducts1 = new OrderProducts();
        $orderProducts1->setQuantity(2);
        $orderProducts1->setProducts($products[0]);
        $orderProducts1->setTotalPrice(($orderProducts1->getProducts()->getPrice())*($orderProducts1->getQuantity()));
        $orderProducts1->setOrders($order1);
        $manager->persist($orderProducts1);

        $orderProducts5 = new OrderProducts();
        $orderProducts5->setQuantity(5);
        $orderProducts5->setProducts($products[1]);
        $orderProducts5->setTotalPrice(($orderProducts5->getProducts()->getPrice())*($orderProducts5->getQuantity()));
        $orderProducts5->setOrders($order1);
        $manager->persist($orderProducts5);

        $orderProducts2 = new OrderProducts();
        $orderProducts2->setQuantity(3);
        $orderProducts2->setProducts($products[1]);
        $orderProducts2->setTotalPrice(($orderProducts2->getProducts()->getPrice())*($orderProducts2->getQuantity()));
        $orderProducts2->setOrders($order2);
        $manager->persist($orderProducts2);

        $orderProducts3 = new OrderProducts();
        $orderProducts3->setQuantity(3);
        $orderProducts3->setProducts($products[2]);
        $orderProducts3->setTotalPrice(($orderProducts3->getProducts()->getPrice())*($orderProducts3->getQuantity()));
        $orderProducts3->setOrders($order3);
        $manager->persist($orderProducts3);

        $orderProducts4 = new OrderProducts();
        $orderProducts4->setQuantity(3);
        $orderProducts4->setProducts($products[3]);
        $orderProducts4->setTotalPrice(($orderProducts4->getProducts()->getPrice())*($orderProducts4->getQuantity()));
        $orderProducts4->setOrders($order4);
        $manager->persist($orderProducts4);

        $manager->flush();
    }
}
