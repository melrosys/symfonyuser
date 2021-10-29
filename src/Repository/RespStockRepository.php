<?php

namespace App\Repository;

use App\Entity\RespStock;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RespStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method RespStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method RespStock[]    findAll()
 * @method RespStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RespStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RespStock::class);
    }

    /**
     * 
     */
    public function findAllOrdered($id): array
    {
        $query = $this->createQueryBuilder('lnk')
            ->select('lnk.id', 'lnk.id_resp','use.name','use.id')
            ->innerJoin('App\Entity\User', 'use')
            ->where('lnk.id_resp = use.id')
            ->getQuery();

        return $query->getResult();
/*
        $dql = 'SELECT * FROM A.App\Entity\RespStock LEFT JOIN B.App\Entity\User ON A.id_resp = B.id WHERE A.id_entites = '. $id;
        $query = $this->getEntityManager()->createQuery($dql);
        return array();//$query->execute();*/
    }

    // /**
    //  * @return RespStock[] Returns an array of RespStock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RespStock
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
