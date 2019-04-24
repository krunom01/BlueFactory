<?php

namespace App\Repository;

use App\Entity\TagTrans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TagTrans|null find($id, $lockMode = null, $lockVersion = null)
 * @method TagTrans|null findOneBy(array $criteria, array $orderBy = null)
 * @method TagTrans[]    findAll()
 * @method TagTrans[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagTransRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TagTrans::class);
    }

    // /**
    //  * @return TagTrans[] Returns an array of TagTrans objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TagTrans
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
