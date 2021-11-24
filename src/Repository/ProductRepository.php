<?php

namespace App\Repository;

use App\Entity\SalleProd;
use App\Entity\Product;
use App\Entity\Entites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * 
     */
    public function findLinkCategory($id, $salle_id): array
    {
        /*
        $rawSql = "SELECT p.id_materiel 
        FROM App\Entity\Product AS p
        LEFT JOIN App\Entity\SalleProd AS l 
        WHERE p.id_materiel = " . $id;

        $query = $this->getEntityManager()->createQuery($rawSql);
        return $query->execute();
*/

        $rawSql = "SELECT p.id AS prodid, p.title, p.model, l.quantity, l.sallestorage_id, l.id AS link_id, l.product_id, p.id_catego  
        FROM product AS p 
        LEFT JOIN salle_prod AS l ON p.id = l.product_id AND l.sallestorage_id = ".$salle_id."
        WHERE p.id_catego = " . $id . "
        ";
        $query = $this->getEntityManager()->createQueryBuilder('');
        $stmt = $query->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);
        return $stmt->fetchAll();

        ///$result = $stmt->fetchAll();
        //SELECT l.id AS link_id, p.id AS produit_id, p.name, p.model FROM App\Entity\SalleProd AS l INNER JOIN App\Entity\Product AS p ON p.id = l.product_id WHERE l.sallestorage_id = 9
    }

    /**
     * 
     */
    public function findLinkMateriel($id): array
    {
        /*
        $rawSql = "SELECT p.id_materiel 
        FROM App\Entity\Product AS p
        LEFT JOIN App\Entity\SalleProd AS l 
        WHERE p.id_materiel = " . $id;

        $query = $this->getEntityManager()->createQuery($rawSql);
        return $query->execute();
*/

        $rawSql = "SELECT p.id AS prodid, p.title, p.model, l.quantity, l.sallestorage_id, l.id AS link_id, l.product_id, p.id_materiel 
        FROM product AS p 
        LEFT JOIN salle_prod AS l ON p.id = l.product_id AND l.sallestorage_id = " . $id . "
        WHERE p.title != ''
        ";
        $query = $this->getEntityManager()->createQueryBuilder('');
        $stmt = $query->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);
        return $stmt->fetchAll();

        ///$result = $stmt->fetchAll();
        //SELECT l.id AS link_id, p.id AS produit_id, p.name, p.model FROM App\Entity\SalleProd AS l INNER JOIN App\Entity\Product AS p ON p.id = l.product_id WHERE l.sallestorage_id = 9
    }

    /**
     * 
     */
    public function findMateriel($id, $salle_id): array
    {
        $rawSql = "SELECT p.id AS prodid, p.title, p.model, l.quantity, l.sallestorage_id, l.id AS link_id, l.product_id, p.id_materiel 
        FROM product AS p 
        LEFT JOIN salle_prod AS l ON p.id = l.product_id AND l.sallestorage_id = ".$salle_id."
        WHERE p.id_materiel = ".$id;
        $query = $this->getEntityManager()->createQueryBuilder('');
        $stmt = $query->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
