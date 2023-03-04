<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
use App\Entity\Restaurant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
class OrdersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Orders::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
//https://symfony.com/bundles/EasyAdminBundle/current/fields.html
            Field::new('note'),
            Field::new('status'),
            AssociationField::new('waiter'), //ok
            AssociationField::new('restaurant'), //ok
            DateTimeField::new('orderDate')->setFormat(DateTimeField::FORMAT_LONG, DateTimeField::FORMAT_NONE),


         
           //  DateTimeField::new('orderDate')->setFormat('Y-MM-dd'),

            

        //   DateTimeField::new('orderDate')
           // BOOMField::new('orderDate'),
         //modelo:  MoneyField::new('price')->setCurrency('EUR')
         //DateTimeField::new('orderDate')->setOrderDate(new \DateTime())

      //Boom      Field::new('orderDate'),
            
           //HACE BOOM Field::new('deliverDate'),
           //hACE BOOM    Field::new('waiter'),

          //HACE BOOM Field::new('orderProducts'),
          //   Field::new('restaurant'),

        ];
    }

}
