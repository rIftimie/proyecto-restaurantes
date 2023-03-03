<?php

namespace App\Repository;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use App\Entity\Restaurant;
use App\Entity\User;

/**
 * @extends ServiceEntityRepository<Orders>
 *
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    private $security;
    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Orders::class);
        $this->security = $security;
    }

    public function save(Orders $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Orders $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findOrdersByCurrentUser(): array
    {
        $user = $this->security->getUser();
        $roles = $user->getRoles();
        
        if (in_array('ROLE_SUPER_ADMIN', $roles)) {
            return $this->findAll();
        }

        $restaurant = $user->getRestaurant();
        $restaurantId = $restaurant->getId();

        $query = $this->createQueryBuilder('o')
            ->andWhere('o.restaurant = :restaurant')
            ->setParameter('restaurant', $restaurantId)
            ->getQuery();

        return $query->getResult();
    }
    

//    /**
//     * @return Orders[] Returns an array of Orders objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Orders
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
