Blue Factory Task
$faker = \Faker\Factory::create();
        for ($i = 0; $i < 21; $i++) {
            $meal = (new Meal())
                ->setTitle('novo jelo')
                ->setStatus($faker->randomElement(['created', 'deleted', 'updated']))
                ->setCreatedAt($faker->dateTimeBetween($startDate = '-2 month', $endDate = 'now'))
                ->setUpdatedAt($faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now'))
                ->setDeletedAt($faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now'))
                ->setDesctription('opis jela na hrv jeziku')
                ->setCategory($faker->boolean(30) ? null : $faker->random);
            $manager->persist($meal);
            $manager->flush();
        }
        
        
        
        
        for ($i = 0; $i < 3; $i++) {
            $category = (new Category())
                ->setTitle($i)
                ->setSlug($i);
            $this->setReference('category.abstract', $category);
            $manager->persist($category);

            $categoryTransES = new CategoryTrans();
            $categoryTransES->setCategory($category);
            $categoryTransES->setLanguageCode('es');
            $categoryTransES->setTranslation('Naslov kategorija na ES');
            $manager->persist($categoryTransES);


            $categoryTransDE = new CategoryTrans();
            $categoryTransDE->setCategory($category);
            $categoryTransDE->setLanguageCode('de');
            $categoryTransDE->setTranslation('Naslov kategorija na DE');
            $manager->persist($categoryTransDE);

            $categoryTransUS = new CategoryTrans();
            $categoryTransUS->setCategory($category);
            $categoryTransUS->setLanguageCode('us');
            $categoryTransUS->setTranslation('Naslov kategorija na US');
            $manager->persist($categoryTransUS);

            $manager->flush();

        }