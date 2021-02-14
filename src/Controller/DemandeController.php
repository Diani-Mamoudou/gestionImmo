<?php

namespace App\Controller;

use App\Entity\BienImage;
use App\Entity\Biens;
use App\Entity\Demande;
use App\Form\BiensType;
use App\Form\DemandeType;
use App\Repository\UserRepository;
use App\Repository\BiensRepository;
use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class DemandeController extends AbstractController
{
    /**
     * @Route("/demande/touteDemande", name="touteDemande")
     */
    public function touteDemande(BiensRepository $repo): Response
    {
        $bien =$repo->findBy([
            "etat"=>'Encours'
        ]);
        return $this->render('demande/touteDemande.html.twig', [
            'biens' => $bien,
        ]);
    }

    /**
     * @Route("/demande/showsDetail/{id?}", name="Detail_shows")
     */
    public function showsDetail($id,BiensRepository $repo): Response
    {
        $bien =$repo->find($id);
        return $this->render('demande/detailDemande.html.twig', [
            'bien' => $bien,
        ]);
    }

    /**
     * @Route("/front/modifier/{id?}", name="demande", methods={"POST","GET"})
     */
    
    public function demande($id,EntityManagerInterface $manager,BiensRepository $repo, Request $request): Response{
        $demande= empty($id)? new Biens():$repo->find($id);
        $form=$this->createForm(BiensType::class, $demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($demande);
            $manager->flush();
            return $this->redirectToRoute("front_shows", array('id' => $id));
        }
        return $this->render('demande/form.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/front/add/{id?}", name="newDemande", methods={"POST","GET"})
     */
    
    public function demandes($id,EntityManagerInterface $manager,UserRepository $repo, Request $request): Response{
        $user =$repo->find($id);
        $demande=new Biens();
        $form=$this->createForm(BiensType::class, $demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setUser($user);

            /** @var UploadedFile $images */
            $images=$form->get('bienImage')->getData();
            if ($images){
                foreach ($images as $image) {
                    $fichier= md5(uniqid()).'.'.$image->getClientOriginalExtension();
                    try {
                        $image->move($this->getParameter('images_directory'), $fichier);
                    } catch (FileException $di) {
                        dump($di);
                    }
                    $img= new BienImage();
                    $img->setLibelle($fichier);
                    $demande->addBienImage($img);
                }
            }
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
    public function demandeValid($id,BiensRepository $repo,EntityManagerInterface $manager): Response
    {
        $bien =$repo->find($id);
        if ($bien==null) {
            dd("hjkl");
        }
        if ($bien->getLoyer() != null) {
            $loyer=$bien->getLoyer()+($bien->getLoyer()*0.05);
            $bien->setLoyer($loyer);
        }elseif ($bien->getPrix() != null) {
            $loyer=$bien->getPrix()+($bien->getPrix()*0.05);
            $bien->setPrix($loyer);
        }
        $bien->setEtat("libre");
        $manager->persist($bien);
        $manager->flush();
        
        return $this->redirectToRoute("touteDemande");

    }

    /**
     * @Route("/demande/refuDemande/{id?}", name="refuDemande")
     */
    public function refuDemande($id,BiensRepository $repo,EntityManagerInterface $manager): Response
    {
        $bien =$repo->find($id);
        $manager->remove($bien);
        $manager->flush();
        return $this->redirectToRoute("touteDemande");
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
     * @Route("/demande/reservation/{id?}/{idU?}", name="reservation")
     */
    public function reservation($id,$idU,BiensRepository $repo,UserRepository $repoU,EntityManagerInterface $manager): Response
    {
        $bien =$repo->find($id);
        $user= $repoU->find($idU);
        if ($bien==null) {
            dd("hjkl");
        }
        $demande = new Demande();
        $demande->setDescription($bien->getDescription());
        $demande->setPrix($bien->getPrix());
        $demande->setZone($bien->getZone());
        $demande->setTypeUsage($bien->getTypeUsage());
        $demande->setType($bien->getType());
        $demande->setPhoto($bien->getPhoto());
        $demande->setLoyer($bien->getLoyer());
        $demande->setPeriode($bien->getPeriode());
        $demande->setTypeDema("demReserv");
        $demande->setBien($bien);
        $demande->setUserReserv($user);
        $bien->setEtat("EncoursR");
        $manager->persist($demande);
        $manager->flush();
        
        return $this->redirectToRoute("front_shows");

    }

    /**
     * @Route("/demande/accepte_reservation/{id?}", name="accepte_reservation")
     */
    public function reservValid($id,DemandeRepository $repo,BiensRepository $repob,EntityManagerInterface $manager): Response
    {
        $demande =$repo->find($id);
        $idB=$demande->getBien()->getId();
        $bien= $repob->find($idB);
        if ($demande==null && $bien== null) {
            dd("hjkl");
        }
        
        $demande->setTypeDema("reserve");
        $bien->setEtat("Louer");
        $manager->persist($demande);
        $manager->flush();
        
        return $this->redirectToRoute("touteReservation");

    }

    /**
     * @Route("/demande/refuse/{id?}", name="refureServ")
     */
    public function refureServ($id,DemandeRepository $repo,BiensRepository $repob,EntityManagerInterface $manager): Response
    {
        $demande =$repo->find($id);
        $idB=$demande->getBien()->getId();
        $bien= $repob->find($idB);
        if ($demande==null && $bien== null) {
            dd("hjkl");
        }
        $bien->setEtat("libre");
        $manager->remove($demande);
        $manager->flush();
        return $this->redirectToRoute("touteReservation");
    }

    /**
     * @Route("/demande/demandeShowsByUser/{id}", name="demande_shows_user")
     */
    public function demandeShowsByUser($id,DemandeRepository $repo,UserRepository $repoU): Response
    {
        $user=$repoU->find($id);
        $bien =$repo->findBy([
            "userReserv"=>$user
        ]);        
        return $this->render('user/demandeUi.html.twig', [
            'bien' => $bien,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/demande/delate/{id}", name="demande_delate", methods={"GET"})
     */
    public function delete($id,DemandeRepository $repo,EntityManagerInterface $manager): Response{
        
        $bien=$repo->find($id);
        $manager->remove($bien);
        $manager->flush();
        return $this->redirectToRoute("front_shows");
    }
    
}
