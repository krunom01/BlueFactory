<?php

namespace App\Repository;

use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

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

    public function getMealByTags($tag)
    {
        $tag = explode(',', $tag);
        return $this->createQueryBuilder('b')
            ->innerJoin('App\Entity\TagMeal', 'co', 'WITH', 'co.meal = b.id')
            ->where('co.tag IN (:tag)')
            ->setParameter('tag', array_values($tag))
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }
    public function getMealByTagsTime($tag, $time)
    {
        $time = date('Y-m-d', $time);
        $tag = explode(',', $tag);
        return $this->createQueryBuilder('b')
            ->innerJoin('App\Entity\TagMeal', 'co', 'WITH', 'co.meal = b.id')
            ->andWhere('co.tag IN (:tag)')
            ->andWhere('b.created_at > :time')
            ->setParameter('tag', array_values($tag))
            ->setParameter('time', $time)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function getMealsByCategory($value)
    {

        if ($value == 'null') {
            $meals = $this->createQueryBuilder('m')
                ->andWhere('m.category IS  NULL')
                ->getQuery()
                ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
        } elseif ($value == '!null') {
            $meals = $this->createQueryBuilder('m')
                ->andWhere('m.category IS NOT NULL')
                ->getQuery()
                ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
        } else {
            $meals = $this->createQueryBuilder('m')
                ->andWhere('m.category = :value')
                ->setParameter('value', $value)
                ->getQuery()
                ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
        }
        return $meals;
    }
    public function getMealsByCategoryTime($value, $time)
    {

        $time = date('Y-m-d', $time);

        if ($value == 'null') {
            $meals = $this->createQueryBuilder('m')
                ->andWhere('m.category IS  NULL')
                ->andWhere('m.created_at > :time')
                ->setParameter('time', $time)
                ->getQuery()
                ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
        } elseif ($value == '!null') {
            $meals = $this->createQueryBuilder('m')
                ->andWhere('m.category IS NOT NULL')
                ->andWhere('m.created_at > :time')
                ->setParameter('time', $time)
                ->getQuery()
                ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
        } else {
            $meals = $this->createQueryBuilder('m')
                ->andWhere('m.category = :value')
                ->andWhere('m.created_at > :time')
                ->setParameter('value', $value)
                ->setParameter('time', $time)
                ->getQuery()
                ->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
        }
        return $meals;
    }
}
