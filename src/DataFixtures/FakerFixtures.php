<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Languages;
use App\Entity\CategoryTrans;
use App\Repository\LanguagesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class FakerFixtures extends Fixture
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