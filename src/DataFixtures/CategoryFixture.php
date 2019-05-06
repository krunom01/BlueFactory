<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\CategoryTrans;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixture extends Fixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */

    public function load(ObjectManager $manager)
    {


    }
    public function getOrder()
    {
        return 100;
    }
}