<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user/showUserByProfil/{profil}", name="user_by_profil", methods={"POST","GET"})
     */
    public function showUserByProfil($profil,ProfilRepository $repo,UserRepository $repoU): Response
    {
        $profil =$repo->findBy([
            "libelle"=>$profil
        ]);

        $user =$repoU->findBy([
            "profil"=>$profil
        ]);
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'profil' => $profil,
        ]);
        
    }

    /**
     * @Route("/user/MonProfil/{id}", name="mon_profil", methods={"POST","GET"})
     */
    public function monProfil($id,UserRepository $repo): Response
    {
        $user =$repo->findBy([
            "id"=>$id
        ]);
        return $this->render('user/monProfil.html.twig', [
            'user' => $user,
        ]);
        
    }

    
    

}
