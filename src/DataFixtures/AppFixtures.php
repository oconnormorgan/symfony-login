<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\UserEntity;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         $user = new UserEntity();
         $user->setEmail('admin@symfonylogin.fr');
         $user->setPassword('password');
         $user->setFirstname('admin');
         $user->setLastname('ADMIN');
         $manager->persist($user);

        $manager->flush();
    }
}
