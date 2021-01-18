<?php

namespace App\Controller;

use App\Entity\Biens;
use App\Entity\Demande;
use App\Form\DemandeType;
use App\Repository\BiensRepository;
use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandeController extends AbstractController
{
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
     * @Route("/demande/touteReservation", name="touteReservation")
     */
    public function touteReservation(DemandeRepository $repo): Response
    {
        $bien =$repo->findBy([
            "typeDema"=>'demReserv'
        ]);
        return $this->render('demande/touteReservation.html.twig', [
            'biens' => $bien,
        ]);
    }


    /**
     * @Route("/demande/showsDetail/{id?}", name="Detail_shows")
     */
    public function showsDetail($id,DemandeRepository $repo): Response
    {
        $bien =$repo->find($id);
        return $this->render('demande/detailDemande.html.twig', [
            'bien' => $bien,
        ]);
    }

    /**
     * @Route("/demande/showsDetailReserv/{id?}", name="DetailReserv_shows")
     */
    public function showsDetailReserv($id,DemandeRepository $repo): Response
    {
        $bien =$repo->find($id);
        return $this->render('demande/detailReservation.html.twig', [
            'bien' => $bien,
        ]);
    }

    /**
     * @Route("/front/add", name="demande", methods={"POST","GET"})
     */
    
    public function demande(EntityManagerInterface $manager, Request $request): Response{
        $demande= new Demande();
        $form=$this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setTypeDema("demGestion");
            $manager->persist($demande);
            $manager->flush();
            return $this->redirectToRoute("front_shows");
        }
        return $this->render('demande/form.html.twig', [
            'form' => $form->createView()
        ]);
        
    }


    

    /**
     * @Route("/demande/accDem/{id?}", name="accepte_demande")
     */
    public function demandeValid($id,DemandeRepository $repo,EntityManagerInterface $manager): Response
    {
        $demande =$repo->find($id);
        if ($demande==null) {
            dd("hjkl");
        }
        $bien = new Biens();
        $bien->setDescription($demande->getDescription());
        $bien->setPrix($demande->getPrix());
        $bien->setZone($demande->getZone());
        $bien->setTypeUsage($demande->getTypeUsage());
        $bien->setType($demande->getType());
        $bien->setPhoto($demande->getPhoto());
        $bien->setPeriode($demande->getPeriode());
        $manager->persist($bien);
        $manager->remove($demande);
        $manager->flush();
        
        return $this->redirectToRoute("touteDemande");

    }


    /**
     * @Route("/demande/accepte_reservation/{id?}", name="accepte_reservation")
     */
    public function reservValid($id,DemandeRepository $repo,EntityManagerInterface $manager): Response
    {
        $demande =$repo->find($id);
        if ($demande==null) {
            dd("hjkl");
        }
        $bien = new Biens();
        $bien->setDescription($demande->getDescription());
        $bien->setPrix($demande->getPrix());
        $bien->setZone($demande->getZone());
        $bien->setTypeUsage($demande->getTypeUsage());
        $bien->setType($demande->getType());
        $bien->setPhoto($demande->getPhoto());
        $bien->setPeriode($demande->getPeriode());
        $bien->setEtat("louer");
        $manager->persist($bien);
        $manager->remove($demande);
        $manager->flush();
        
        return $this->redirectToRoute("touteReservation");

    }


    /**
     * @Route("/demande/refuDemande/{id?}", name="refuDemande")
     */
    public function refuDemande($id,DemandeRepository $repo,EntityManagerInterface $manager): Response
    {
        $bien =$repo->find($id);
        $manager->remove($bien);
        $manager->flush();
        return $this->redirectToRoute("touteDemande");
    }

    /**
     * @Route("/demande/refuse/{id?}", name="refureServ")
     */
    public function refureServ($id,DemandeRepository $repo,EntityManagerInterface $manager): Response
    {
        $demande =$repo->find($id);
        if ($demande==null) {
            dd("hjkl");
        }
        $bien = new Biens();
        $bien->setDescription($demande->getDescription());
        $bien->setPrix($demande->getPrix());
        $bien->setZone($demande->getZone());
        $bien->setTypeUsage($demande->getTypeUsage());
        $bien->setType($demande->getType());
        $bien->setPhoto($demande->getPhoto());
        $bien->setPeriode($demande->getPeriode());
        $manager->persist($bien);
        $manager->remove($demande);
        $manager->flush();
        return $this->redirectToRoute("touteDemande");
    }
    
}
