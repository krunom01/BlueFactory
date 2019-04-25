<?php

namespace App\Repository;

use App\Entity\CategoryTrans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategoryTrans|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryTrans|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryTrans[]    findAll()
 * @method CategoryTrans[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryTransRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategoryTrans::class);
    }
    public function getCategoryByLang($lancode)
    {
        return $this->createQueryBuilder('b')
            ->select('b.translation')
            ->innerJoin('App\Entity\Category', 'co', 'WITH', 'co.id = b.id')
            ->andWhere('b.languageCode = :lancode')
            ->setParameter('lancode', $lancode)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return CategoryTrans[] Returns an array of CategoryTrans objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryTrans
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
