<?php


namespace App\DataFixtures;

use App\Entity\Meal;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\MealRepository;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class MealFixture extends Fixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */

    public function load(ObjectManager $manager)
    {

        $loader = new NativeLoader();
        $objectSet = $loader->loadFile(__DIR__.'/Fixtures.yml')->getObjects();
        foreach ($objectSet as $object) {
            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 200;
    }
}