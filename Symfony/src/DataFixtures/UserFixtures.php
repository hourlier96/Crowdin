<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 10; $i++){
            $user = new User();
            $user->setUsername("Username n° $i")
                 ->setPassword("password n° $i")
                 ->setEmail("$i@gmail.com")
                 ->setDescr("Salut");
            $manager->persist($user);
        }
        $manager->flush();
    }
}
