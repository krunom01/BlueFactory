<?php

namespace App\Repository;

use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Meal::class);
    }
    public function findById($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function getMealByTags($tag)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('App\Entity\TagMeal', 'co', 'WITH', 'co.meal = b.id')
            ->andWhere('co.tag IN (:tag)')
            ->setParameter('tag', $tag)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }
    public function getMealByTagsTime($tag,$time)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('App\Entity\TagMeal', 'co', 'WITH', 'co.meal = b.id')
            ->andWhere('co.tag IN (:tag)')
            ->andWhere('b.created_at > :time')
            ->setParameter('tag', $tag)
            ->setParameter('time', $time)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    /*
    public function findOneBySomeField($value): ?Meal
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
