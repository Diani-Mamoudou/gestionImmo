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

class FrontController extends AbstractController
{
    /**
     * @Route("/front/shows", name="front_shows")
     */
    public function show(BiensRepository $repo): Response
    {
        $bien =$repo->findBy([
            "etat"=>'libre'
        ]);
        return $this->render('front/index.html.twig', [
            'biens' => $bien,
        ]);
    }


    /**
     * @Route("/front/detail/{id?}", name="detail", methods={"GET"})
     */
    public function detail($id,Biens $bien,BiensRepository $repo): Response
    {
        $biens=$repo->find($id);
        return $this->render('front/detail.html.twig', [
            'bien' => $biens
        ]);
    }


    /**
     * @Route("/front/add/{id?}", name="front_add", methods={"POST","GET"})
     */
    public function save($id,BiensRepository $repo,EntityManagerInterface $manager, Request $request): Response{
        $bien = empty($id)? new Biens():$repo->find($id) ;
        $form=$this->createForm(BiensType::class, $bien);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($bien);
            $manager->flush();
            return $this->redirectToRoute("front_shows");
        }
        return $this->render('front/form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/front/delete/{id}", name="front_delate", methods={"GET"})
     */
    public function delete($id,BiensRepository $repo,EntityManagerInterface $manager): Response{
        
        $bien=$repo->find($id);
        $manager->remove($bien);
        $manager->flush();
        return $this->redirectToRoute("front_shows");
    }
}