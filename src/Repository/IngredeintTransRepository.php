<?php

namespace App\Repository;

use App\Entity\IngredeintTrans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IngredeintTrans|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredeintTrans|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredeintTrans[]    findAll()
 * @method IngredeintTrans[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredeintTransRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IngredeintTrans::class);
    }

    // /**
    //  * @return IngredeintTrans[] Returns an array of IngredeintTrans objects
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
    public function findOneBySomeField($value): ?IngredeintTrans
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
