<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandeController extends AbstractController
{
    /**
     * @Route("/demande/shows", name="demande_shows")
     */
    public function shows(DemandeRepository $repo): Response
    {
        $bien =$repo->findAll();
        return $this->render('demande/index.html.twig', [
            'biens' => $bien,
        ]);
    }


    /**
     * @Route("/demande/touteDemande", name="touteDemande")
     */
    public function touteDemande(DemandeRepository $repo): Response
    {
        $bien =$repo->findBy([
            "typeDema"=>'demGestion'
        ]);
        return $this->render('demande/touteDemande.html.twig', [
            'biens' => $bien,
        ]);
    }


    /**
     * @Route("/demande/gestBien", name="demande_gestBien", methods={"POST","GET"})
     */
    public function save(DemandeRepository $repo,EntityManagerInterface $manager, Request $request): Response{
        $demande = new Demande();
        $form=$this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $demande->setTypeDema("demGestion");
            $manager->persist($demande);
            $manager->flush();
            return $this->redirectToRoute("demande_gestBien");
        }
        
        return $this->render('demande/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
