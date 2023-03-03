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

    //Get the money earned by the restaurant for a given period of time
    public function getMoneyEarned(Restaurant $restaurant, \DateTime $startDate, \DateTime $endDate): float
    {
        $query = $this->createQueryBuilder('o')
            ->innerJoin('o.orderProducts', 'op')
            ->andWhere('o.restaurant = :restaurant')
            ->andWhere('o.createdAt BETWEEN :startDate AND :endDate')
            ->setParameter('restaurant', $restaurant)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->select('SUM(op.totalPrice * op.quantity) as total')
            ->getQuery();

        $result = $query->getOneOrNullResult();

        return $result['total'] ?? 0;
    }

    //Get the money per order for a given period of time
    public function getMoneyPerOrder(Restaurant $restaurant, \DateTime $startDate, \DateTime $endDate): float
    {
        $query = $this->createQueryBuilder('o')
            ->innerJoin('o.orderProducts', 'op')
            ->andWhere('o.restaurant = :restaurant')
            ->andWhere('o.createdAt BETWEEN :startDate AND :endDate')
            ->setParameter('restaurant', $restaurant)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->select('SUM(op.totalPrice * op.quantity) as total')
            ->getQuery();

        $result = $query->getResult();

        return count($result) > 0 ? array_sum(array_column($result, 'total')) / count($result) : 0;
    }

    //Number of orders by waiter for a given period of time
    public function getOrdersByWaiter(Restaurant $restaurant, \DateTime $startDate, \DateTime $endDate): array
    {
        $query = $this->createQueryBuilder('o')
            ->innerJoin('o.waiter', 'w')
            ->andWhere('o.restaurant = :restaurant')
            ->andWhere('o.createdAt BETWEEN :startDate AND :endDate')
            ->setParameter('restaurant', $restaurant)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->select('w.id as waiterId, w.firstName as waiterFirstName, w.lastName as waiterLastName, COUNT(o.id) as total')
            ->groupBy('w.id')
            ->orderBy('total', 'DESC')
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