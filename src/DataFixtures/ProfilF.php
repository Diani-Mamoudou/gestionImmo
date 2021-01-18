<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfilF extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $libelles=[
            "Gestionnaire",
            "Proprietaire",
            "Client"
        ];

        foreach ($libelles as $key => $libelle) {
            $profil=new Profil();
            $profil->setLibelle($libelle);
            $manager->persist($profil);
        }

        $manager->flush();
    }
}
