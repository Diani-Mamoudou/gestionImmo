<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Form\BiensType;
use App\Repository\UserRepository;
use App\Repository\BiensRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BiensController extends AbstractController
{
    /**
     * @Route("/biens/shows", name="biens_shows")
     */
    public function show(BiensRepository $repo): Response
    {
        $bien=$repo->findAll();
        return $this->render('biens/index.html.twig', [
            'bien' => $bien,
        ]);
    }

    /**
     * @Route("/biens/modifier/{id?}", name="modifier", methods={"POST","GET"})
     */
    
    public function modif($id,EntityManagerInterface $manager,BiensRepository $repo, Request $request): Response{
        $demande= empty($id)? new biens():$repo->find($id);
        $form=$this->createForm(BiensType::class, $demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($demande);
            $manager->flush();
            return $this->redirectToRoute("detail", array('id' => $id));
        }
        return $this->render('biens/form.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/biens/delate/{id}", name="bien_delate", methods={"GET"})
     */
    public function delete($id,BiensRepository $repo,EntityManagerInterface $manager): Response{
        
        $bien=$repo->find($id);
        $manager->remove($bien);
        $manager->flush();
        return $this->redirectToRoute("front_shows");
    }
    
     /**
     * @Route("/biens/showBienByType/{type}", name="bien_by_type", methods={"POST","GET"})
     */
    public function showBienByType($type,BiensRepository $repo,EntityManagerInterface $manager): Response
    {
        $bien =$repo->findBy([
            "type"=>$type
        ]);
        return $this->render('front/index.html.twig', [
            'biens' => $bien ]);
        
    }

    /**
     * @Route("/biens/bienShowsByUser/{id}", name="biens_shows_user")
     */
    public function bienShowsByUser($id,BiensRepository $repo,UserRepository $repoU): Response
    {
        $user=$repoU->find($id);
        $bien =$repo->findBy([
            "user"=>$user
        ]);
        return $this->render('user/bienUi.html.twig', [
            'bien' => $bien,
            'user' => $user,
        ]);
    }
    

    
}
