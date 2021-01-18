<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Profil;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserF extends Fixture
{
    private $repoProfil;
    private $encoder;
    public function __construct(ProfilRepository $repoProfil, UserPasswordEncoderInterface $encoder)
    {
        $this->repoProfil=$repoProfil;
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager)
    {
        $profils=$this->repoProfil->findAll();
        foreach ($profils as $key => $profil) {
            for ($i=1; $i < 2; $i++) { 
                $user=new User();
                $pwd=$this->encoder->encodePassword($user,strtolower($profil->getLibelle()));
                $user->setEmail(strtolower($profil->getLibelle()).$i."@gmail.com")
                    ->setProfil($profil)
                    ->setPassword($pwd);
                    $manager->persist($user);
            }
            
        }
        $manager->flush();
    }
}
