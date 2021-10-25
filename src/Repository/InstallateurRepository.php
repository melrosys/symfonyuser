<?php

namespace App\Repository;

use App\Entity\Installateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Installateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Installateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Installateur[]    findAll()
 * @method Installateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstallateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Installateur::class);
    }

    // /**
    //  * @return Installateur[] Returns an array of Installateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Installateur
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
