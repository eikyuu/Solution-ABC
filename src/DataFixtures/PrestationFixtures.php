<?php

namespace App\DataFixtures;

use App\Entity\Job;
use App\Entity\Prestation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PrestationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 20; $i++) {
            $job = new Job();
            $job->setNameJob($faker->jobTitle);
            $manager->persist($job);
            $prestation = new Prestation();
            $prestation->setName($faker->jobTitle);
            $prestation->setJob($job);
            $manager->persist($prestation);
        }
        $manager->flush();
    }
}
