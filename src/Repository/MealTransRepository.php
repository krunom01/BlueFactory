<?php

namespace App\Repository;

use App\Entity\MealTrans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MealTrans|null find($id, $lockMode = null, $lockVersion = null)
 * @method MealTrans|null findOneBy(array $criteria, array $orderBy = null)
 * @method MealTrans[]    findAll()
 * @method MealTrans[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealTransRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MealTrans::class);
    }

    // /**
    //  * @return MealTrans[] Returns an array of MealTrans objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MealTrans
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
