<?php

namespace App\Repository;

use App\Entity\OrderProducts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderProducts>
 *
 * @method OrderProducts|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderProducts|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderProducts[]    findAll()
 * @method OrderProducts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderProducts::class);
    }

    public function save(OrderProducts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderProducts $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Returns the products of an order
     * @param int $idOrder
     * @return array
     */
    public function getProductsByOrder($idOrder): array
    {
        $products = $this->createQueryBuilder('op')
            ->innerJoin('op.product', 'p')
            ->innerJoin('op.order', 'o')
            ->where('o.id = :idOrder')
            ->setParameter('idOrder', $idOrder)
            ->getQuery()
            ->getResult();

        return $products;
    }
    public function getProductsByOrderAndProd($idOrder, $idProd): array
    {
        $products = $this->createQueryBuilder('op')
            ->innerJoin('op.products', 'p')
            ->innerJoin('op.orders', 'o')
            ->where('o.id = :idOrder AND p.id = :idProd')
            ->setParameter('idOrder', $idOrder)
            ->setParameter('idProd', $idProd)
            ->getQuery()
            ->getResult();

        return $products;
    }

    //Get the total number of products sold in a given period of time
    public function getTotalProductsSold($idRestaurant, $startDate, $endDate): int
    {
        $totalProductsSold = $this->createQueryBuilder('op')
            ->innerJoin('op.product', 'p')
            ->innerJoin('p.menus', 'm')
            ->innerJoin('m.restaurant', 'r')
            ->innerJoin('op.order', 'o')
            ->where('r.id = :idRestaurant')
            ->andWhere('o.status = 3')
            ->andWhere('o.date BETWEEN :startDate AND :endDate')
            ->setParameter('idRestaurant', $idRestaurant)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->select('SUM(op.quantity) as totalProductsSold')
            ->getQuery()
            ->getSingleScalarResult();

        return $totalProductsSold;
    }

    //Most requested products for a given period of time
    public function getMostRequestedProducts($idRestaurant, $startDate, $endDate): array
    {
        $products = $this->createQueryBuilder('op')
            ->innerJoin('op.product', 'p')
            ->innerJoin('p.restaurant', 'r')
            ->innerJoin('op.order', 'o')
            ->where('r.id = :idRestaurant')
            ->andWhere('o.date BETWEEN :startDate AND :endDate')
            ->setParameter('idRestaurant', $idRestaurant)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();

        return $products;
    }

//    /**
//     * @return OrderProducts[] Returns an array of OrderProducts objects
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

//    public function findOneBySomeField($value): ?OrderProducts
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}