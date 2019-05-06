<?php

namespace App\Repository;

use App\Entity\TagMeal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TagMeal|null find($id, $lockMode = null, $lockVersion = null)
 * @method TagMeal|null findOneBy(array $criteria, array $orderBy = null)
 * @method TagMeal[]    findAll()
 * @method TagMeal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagMealRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TagMeal::class);
    }


    public function getMealByTags($tag)
    {

        return $this->createQueryBuilder('b')
            ->where('b.tag IN (:tag)')
            ->setParameter('tag', array($tag))
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }


    /*
    public function findOneBySomeField($value): ?TagMeal
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
