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


    





    
    
}
