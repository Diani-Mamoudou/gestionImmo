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


    

}
