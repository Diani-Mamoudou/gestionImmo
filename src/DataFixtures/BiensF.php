<?php

namespace App\DataFixtures;

use App\Entity\Biens;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BiensF extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1;$i<21;$i++){
            $bien = new Biens();
            $bien->setDescription("C'est un fait établi depuis longtemps qu'un lecteur sera distrait par le contenu lisible d'une page lorsqu'il regarde sa mise en page. L'intérêt d'utiliser Lorem Ipsum est qu'il a une distribution plus ou moins normale des lettres, par opposition à l'utilisation de «Contenu ici, contenu ici», ce qui le fait ressembler à un anglais lisible. De nombreux progiciels de publication assistée par ordinateur et éditeurs de pages Web utilisent désormais Lorem Ipsum comme modèle de texte par défaut, et une recherche sur «lorem ipsum» permettra de découvrir de nombreux sites Web encore à leurs balbutiements. Différentes versions ont évolué au fil des années, parfois par accident, parfois exprès (humour injecté, etc.).");
            $bien->setPrix(200+$i);
            $bien->setType("vendre");
            $bien->setZone("médina");
            $bien->setTypeUsage("bureau");
            $manager->persist($bien);
        }
        $manager->flush();
    }
}
