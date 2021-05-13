<?php

namespace App\Repository;

use App\Entity\SJ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SJ|null find($id, $lockMode = null, $lockVersion = null)
 * @method SJ|null findOneBy(array $criteria, array $orderBy = null)
 * @method SJ[]    findAll()
 * @method SJ[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SJRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SJ::class);
    }

    // /**
    //  * @return SJ[] Returns an array of SJ objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SJ
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
