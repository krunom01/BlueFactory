<?php


namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class MealFixture extends Fixture
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
}