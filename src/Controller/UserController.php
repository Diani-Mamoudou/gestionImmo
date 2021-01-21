<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user/show_client/{profil?}", name="show_client")
     */
    public function showClient($profil,UserRepository $repo): Response
    {
        $user =$repo->findBy([
            "profil"=>$profil
        ]);
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'profil' => $profil,
        ]);
    }
}
