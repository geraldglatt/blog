<?php

namespace App\DataFixtures;

use App\Entity\Post\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i =0; $i < 50; $i++) {
            $post = new Post();
            dd(Post::class);
            $post->setTitle($faker->words(4, true))
                 ->setContent($faker->realText(1800))
                 ->setState(mt_rand(0,2) === 1 ? Post::STATES[0]: POST::STATES[1]);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
