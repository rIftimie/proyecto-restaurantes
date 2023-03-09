<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @extends ServiceEntityRepository<Restaurant>
 *
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    private $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Restaurant::class);
        $this->security = $security;
    }

    public function save(Restaurant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Restaurant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush)
        {
            $this->getEntityManager()->flush();
        }
    }
    public function getRestaurant(): array
    {
        $user = $this->security->getUser();
        $roles = $user->getRoles();
        if (in_array('ROLE_SUPER_ADMIN', $roles))
        {
            $restaurants = $this->findAll();
        }
        else
        {
            $idUsuario = $user->getId();
            $restaurants = $this->createQueryBuilder('r')
                ->innerJoin('r.users', 'u')
                ->where('u.id = :idUsuario')
                ->setParameter('idUsuario', $idUsuario)
                ->getQuery()
                ->getResult();
        }
        $choices = [];
        foreach ($restaurants as $restaurant)
        {
            $choices[$restaurant->getName()] = $restaurant;
        }
        return $choices;
    }

    /**
     * Returns the most profitable restaurant
     * @return Restaurant[] Returns an array of Restaurant objects
     */
    public function getMostProfitableRestaurant(): array
    {
        $restaurants = $this->createQueryBuilder('r')
            ->select('r.name, SUM(o.total) as total')
            ->innerJoin('r.orders', 'o')
            ->groupBy('r.name')
            ->orderBy('total', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
        return $restaurants;
    }
    public function findOneById($value): ?Restaurant
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

//    /**
//     * @return Restaurant[] Returns an array of Restaurant objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Restaurant
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}