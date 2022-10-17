<?php

namespace App\DataFixtures;

use App\Entity\Hamster;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hamster = new Hamster();
        $hamster->setName('Die fette Kugel');
        $hamster->setWeight(5000);

        $manager->persist($hamster);
        $manager->flush();
    }
}
