<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use App\Entity\Pfe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EntrepriseFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create();
        for($i=0;$i<20;$i++){
            $entreprise=new Entreprise();
            $entreprise->setNameEntreprise($faker->company);
            for ($j=0;$j<rand(0,10);$j++){
                $pfe=new Pfe();
                $pfe->setTitle($faker->title);
                $pfe->setNameStudent($faker->name);
                $entreprise->addListePfe($pfe);
                $pfe->setEntreprise($entreprise);
                $manager->persist($pfe);
            }
            $manager->persist($entreprise);
        }

        $manager->flush();
    }
}
