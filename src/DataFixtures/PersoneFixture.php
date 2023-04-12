<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Persone;
use Faker\Factory;

class PersoneFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create(locale:'fr_FR');
        for($i = 0; $i < 100; $i++){
            $persone = new Persone();
            $persone -> setFirstname($faker->firstname);
            $persone -> setname($faker->name);
            $persone -> setAge($faker->numberBetween(18, 65));

            $manager->persist($persone);
        }
        // $product = new Product();
        //$manager->persist($product);

        $manager->flush();
    }
}
