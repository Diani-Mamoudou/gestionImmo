<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Form\BiensType;
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
     * @Route("/front/modifier/{id?}", name="modifier", methods={"POST","GET"})
     */
    
    public function modif($id,EntityManagerInterface $manager,BiensRepository $repo, Request $request): Response{
        $demande= empty($id)? new biens():$repo->find($id);
        $form=$this->createForm(BiensType::class, $demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($demande);
            $manager->flush();
            return $this->redirectToRoute("front_shows", array('id' => $id));
        }
        return $this->render('biens/form.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/front/delate/{id}", name="bien_delate", methods={"GET"})
     */
    public function delete($id,BiensRepository $repo,EntityManagerInterface $manager): Response{
        
        $bien=$repo->find($id);
        $manager->remove($bien);
        $manager->flush();
        return $this->redirectToRoute("front_shows");
    }
    

}
