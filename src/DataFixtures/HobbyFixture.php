<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Hobby;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "Aller en campagne",
            "Aller à la plage",
            "Aller à la pêche",
            "Se promener en montagnes",
            "Faire du camping",
            "Marcher en ville, faire du lèche-vitrine",
            "Visiter une autre ville",
            "Aller à un zoo, un carnaval",
            "Aller au parc, à un piquenique ou un barbecue",
            "Aller à un ciné-parc",
            "Visiter des endroits particuliers",
            "Restaurant"
        ];

        for($i = 0; $i < count($data); $i++){
            $hobby = new Hobby();
            $hobby->setDesignation($data[$i]);
            $manager->persist($hobby);
           }
   
           $manager->flush();
    }
}
