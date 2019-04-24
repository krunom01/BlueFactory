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

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setTitle('Naslov kat'.$i.'na HRV');
            $category->setSlug('Category' . $i);
            $manager->persist($category);
            $manager->flush();

        }

        $languages = [
            'es' => 'Spanish',
            'de' => 'German',
            'fr' => 'French'
        ];
       foreach ($languages as $lang => $value) {
           $newLang = new Languages();
           $newLang->setName($value);
           $newLang->setCode($lang);
           $manager->persist($newLang);
           $manager->flush();

       }


    }

}