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
     * @Route("/user/show_client/{profil?}", name="show_client")
     */
    public function showClient($profil,UserRepository $repo): Response
    {
        $user =$repo->findBy([
            "profil"=>$profil
        ]);
        dd($user);

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'profil' => $profil,
        ]);
    }

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

    
    /**
     * @Route("/user/modifierUser/{id?}", name="modifier_user", methods={"POST","GET"})
     */
    
    public function modifierUser($id,EntityManagerInterface $manager,UserRepository $repo, Request $request): Response{
        $user =$repo->find($id);
        $form=$this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute("mon_profil", array('id' => $id));
        }
        return $this->render('user/form.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

}
