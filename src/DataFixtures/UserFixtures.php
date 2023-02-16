<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {
        
    }

    public function load(
        ObjectManager $manager,
        ): void
    {
        $faker = Factory::create('fr_FR');

        //my user
        $user = new User();
            $user->setEmail('gege@blog.fr')
                 ->setFirstName('gégé')
                 ->setPassword(
                    $this->hasher->hashPassword($user, 'password')
                );

            $manager->persist($user);

        for($i=0;$i < 9;$i++) {
            $users = new User();
            $users->setEmail($faker->email())
                 ->setLastName($faker->lastName())
                 ->setFirstName($faker->firstName())
                 ->setPassword(
                    $this->hasher->hashPassword($users, 'password')
                 );

            $manager->persist($users);
            
        }

        $manager->flush();
    }
}