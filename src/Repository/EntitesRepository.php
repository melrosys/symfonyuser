<?php

namespace App\Repository;

use App\Entity\Entites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entites[]    findAll()
 * @method Entites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entites::class);
    }

    /**
     * 
     */
    public function findAllOrdered(): array
    {
        $dql = 'SELECT cat.name, cat.ville, cat.id FROM App\Entity\Entites cat ORDER BY cat.name DESC';
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->execute();
    }
    // /**
    //  * @return Entites[] Returns an array of Entites objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entites
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
