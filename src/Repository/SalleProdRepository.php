<?php

namespace App\Repository;

use App\Entity\SalleProd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SalleProd|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalleProd|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalleProd[]    findAll()
 * @method SalleProd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalleProdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalleProd::class);
    }

    // /**
    //  * @return SalleProd[] Returns an array of SalleProd objects
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
    public function findOneBySomeField($value): ?SalleProd
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
