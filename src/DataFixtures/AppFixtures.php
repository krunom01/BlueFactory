<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {


        $faker = \Faker\Factory::create();
        $populator = new \Faker\ORM\Propel\Populator($faker);
        $populator->addEntity(Category::class, 3);
        $populator->execute();
    }
}
