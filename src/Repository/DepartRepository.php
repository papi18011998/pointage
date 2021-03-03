<?php

namespace App\Repository;

use App\Entity\Depart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Depart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Depart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Depart[]    findAll()
 * @method Depart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Depart::class);
    }

    // /**
    //  * @return Depart[] Returns an array of Depart objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Depart
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
