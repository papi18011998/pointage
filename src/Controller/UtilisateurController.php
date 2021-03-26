<?php

namespace App\Controller;

use App\Entity\Depart;
use App\Entity\Pointage;
use App\Form\DepartType;
use App\Form\PointageType;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\VehiculeRepository;
use App\Repository\LivraisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController
{

    //----------------------------------Espace authentification et redirection de l'utilisateur en fonction de son role-------------------------------//
    /**
     * @Route("/", name="userLogin")
     */
    public function index() {
       return $this->render('utilisateur/index.html.twig');
    }
    /**
     * @Route("/roles", name="roles")
     *
     */
    public function roles() 
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }
        else{
            return $this->redirectToRoute('chauffeur'); 
        }
    }
    //----------------------------------Espace réservé à l'administrateur------------------------------------//
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(){
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null,"Vos droits ne sont pas suffisants pour acceder à cette partie");
        return $this->render('utilisateur/admin.html.twig');
    }
    //----------------------------------Espace réservé au chauffeur------------------------------------//
    /**
     * @Route("/chauffeur", name="chauffeur")
     */
    public function chauffeur(Request $request,Depart $depart = null,LivraisonRepository $livraisonRepo, Pointage $pointage = null,EntityManagerInterface $manager){
        $this->denyAccessUnlessGranted('ROLE_CHAUFFEUR',null,"Vos droits ne sont pas suffisants pour acceder à cette partie");
        // Démarrage de la journée du chauffeur
        if(!$depart){
            $depart = new Depart();
        }
        $form = $this->createForm(DepartType::class,$depart);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $depart->setHeureDepart(new \DateTime())
                   ->setJour(new \DateTime());
            $depart->setUtilisateur($this->getUser());
            //Affectation du vehicule au chauffeur
            $this->getUser()->addVehicule($depart->getVehicule());
            $manager->persist($depart);
            $manager->flush();
        }
        // Faire un pointage
        if(!$pointage){
            $pointage = new Pointage();
        } 
        $formMakeScore = $this->createForm(PointageType::class,$pointage);
        $formMakeScore->handleRequest($request);
        if ($formMakeScore->isSubmitted() && $formMakeScore->isValid()) {
            // reception et traitement de la requete
            $pointage->setUtilisateur($this->getUser());
            $livraison = $livraisonRepo->findById($pointage->getLivraison());
            // $pointage->setPointDeLivraison($livraison->getLibelle());
            // $pointage->setPointDeLivraison();
            dump($livraison->getLibelle());
            // $manager->persist($pointage);
            // $manager->flush();
        }      
        return $this->render('utilisateur/chauffeur.html.twig',['form'=>$form->createView(),'formMakeScore'=>$formMakeScore->createView()]);
    }
    //----------------------------------Déconnexion de l'utilisateur--------------------------------//
    /**
     * @Route("/logout", name="userDisconnect")
     */
    public function logout(){}
}
