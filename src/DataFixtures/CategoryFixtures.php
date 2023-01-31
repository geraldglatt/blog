<?php

namespace App\DataFixtures;

use App\Entity\Post\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($j = 0; $j < 5;$j++){

            $category = new Category();
            $category->setName($faker->name())
                       ->setDescription($faker->paragraph()
        );
        $manager->persist($category);

        }
        $manager->flush();
    }
   

}