<?php
// src/DataFixtures/FakerFixtures.php
namespace App\DataFixtures;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
class FakerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

       for ($i = 0; $i < 10; $i++) {
            $nesto = $faker->word;
            $category = new Category();
            $category->setTitle('CategoryENG');
            $category->setSlug('Category' . $i);
            $manager->persist($category);
        }
        $manager->flush();
    }
}