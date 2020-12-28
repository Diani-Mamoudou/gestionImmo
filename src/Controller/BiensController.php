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
            'biens' => $bien,
        ]);
    }


    /**
     * @Route("/biens/detail/{id?}", name="detail", methods={"GET"})
     */
    public function detail($id,Biens $bien,BiensRepository $repo): Response
    {
        $biens=$repo->find($id);
        return $this->render('biens/detail.html.twig', [
            'bien' => $biens
        ]);
    }


    /**
     * @Route("/biens/add/{id?}", name="biens_add", methods={"POST","GET"})
     */
    public function save($id,BiensRepository $repo,EntityManagerInterface $manager, Request $request): Response{
        $bien = empty($id)? new Biens():$repo->find($id) ;
        $form=$this->createForm(BiensType::class, $bien);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($bien);
            $manager->flush();
            return $this->redirectToRoute("bien_shows");
        }
        return $this->render('biens/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
