<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $profile = new Profile();
         $profile->setRs(rs: 'facebook');
         $profile->setUrl(url: 'https://www.facebook.com/Helena.helena');

         
         $profile1 = new Profile();
         $profile1->setRs(rs: 'Github');
         $profile1->setUrl(url: 'https://github.com/ouridade87');


         $manager->persist($profile);
         $manager->persist($profile1);

        $manager->flush();
    }
}
