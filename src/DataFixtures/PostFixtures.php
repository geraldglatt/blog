<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function __construct(private PostRepository $postRepository)
    {  
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i =0; $i < 50; $i++) {
            $post = new Post();
            $post->setTitle($faker->words(4, true))
                 ->setContent($faker->realText(1800))
                 ->setState(mt_rand(0,2) === 1 ? Post::STATES[0]: POST::STATES[1]);

            $manager->persist($post);

        }

        for($j = 0;$j<5;$j++) {
            $category = new Category();
            $category->setName($faker->words(1, true) . ' ' .$j)
                     ->setDescription(mt_rand(0,1) === 1 ? $faker->realText(254) : null)
                     ->addPost($post);

        $manager->persist($category);

        }
        
        
        $manager->flush();
    }


}
