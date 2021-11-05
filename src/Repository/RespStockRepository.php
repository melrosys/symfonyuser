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
     * @return RespStock[]
     */
    public function findAllUser($id): array
    {
        /*$query = $this->createQueryBuilder('lnk')
            ->select('lnk.id', 'lnk.id_entites', 'lnk.id_resp','use.name','use.id', 'use.email', 'use.username')
            ->innerJoin('App\Entity\User', 'use')
            ->where('lnk.id_resp = use.id and lnk.id_entites = '.$id)
            ->getQuery();
*/
        $query = $this->createQueryBuilder('lnk')
            /*/->select('lnk.id', 'lnk.id_entites', 'lnk.id_resp', 'use.name', 'use.id', 'use.email', 'use.username')*/
            /*->innerJoin('App\Entity\User', 'use')*/
            ->where('lnk.id_entites = ' . $id)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @return RespStock[]
     */
    public function findAllAccessUser($id): array
    {
        $query = $this->createQueryBuilder('lnk')
        ->select('lnk.id', 'lnk.id_entites', 'lnk.id_resp', 'enti.name', 'enti.id', 'enti.ville', 'enti.codep')
        ->innerJoin('App\Entity\Entites', 'enti')
        ->where('lnk.id_resp = '. $id .' and lnk.id_entites = enti.id')
        ->getQuery();

        return $query->getResult();
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
