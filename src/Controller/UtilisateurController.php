<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Depart;
use App\Entity\Incident;
use App\Entity\Pointage;
use App\Entity\Vehicule;
use App\Form\DepartType;
use App\Form\IncidentType;
use App\Form\PointageType;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Form\UtililisateurType;
use App\Repository\DepartRepository;
use App\Repository\PointageRepository;
use App\Repository\VehiculeRepository;
use App\Repository\LivraisonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UtilisateurController extends AbstractController
{

    //----------------------------------Espace authentification et redirection de l'utilisateur en fonction de son role-------------------------------//
    /**
     * @Route("/", name="userLogin")
     */
    public function index(AuthenticationUtils $authenticationUtils) {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('utilisateur/index.html.twig', [
            'last_username' => $lastUsername,
            'error'=> $error,
        ]);
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
    public function admin(Utilisateur $utilisateur = null){
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null,"Vos droits ne sont pas suffisants pour acceder à cette partie");
        if (!$utilisateur) {
            $utilisateur = new Utilisateur();
        }
        // Création du formulaire d'ajout d'utilisateur
        $form = $this->createForm(UtililisateurType::class,$utilisateur);
        return $this->render('utilisateur/admin.html.twig',['formAddUser'=>$form->createView()]);
    }
    //----------------------------------Espace réservé au chauffeur------------------------------------//
    /**
     * @Route("/chauffeur", name="chauffeur")
     */
    public function chauffeur(Request $request,Depart $depart = null,Incident $incident = null, Pointage $pointage = null,LivraisonRepository $livraisonRepository,EntityManagerInterface $manager, DepartRepository $departRepo){
        $this->denyAccessUnlessGranted('ROLE_CHAUFFEUR',null,"Vos droits ne sont pas suffisants pour acceder à cette partie");
        // Démarrage de la journée du chauffeur
        if(!$depart){
            $depart = new Depart();
        }
        $form = $this->createForm(DepartType::class,$depart);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $dep = $departRepo->findOneByUtilisateurByJour($this->getUser(),date("Y-m-d"));
            dump($dep);
            if ($dep!= []) {
                $manager->persist($dep[0]);
                $manager->flush();  
            }else{
            $depart->setHeureDepart(new \DateTime())
                   ->setJour(new \DateTime());
            $depart->setUtilisateur($this->getUser());
            //Affectation du vehicule au chauffeur
            $this->getUser()->addVehicule($depart->getVehicule());
            $depart->getVehicule()->setEtat("occupé");
            $manager->persist($depart);
            $manager->flush();
        }
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
            $pointage->setPointDeLivraison($pointage->getLivraison()->getLibelle());
            $pointage->getLivraison()->setStatut("fait");
            $pointage->setJour( new \DateTime());
            $pointage->setVehicule($this->getUser()->getVehicules()[0]);
            //affectation de la livraison au chauffeur connecté
            $livraisonDoneBy = $livraisonRepository->findOneById($pointage->getLivraison()->getId());
            $livraisonDoneBy->setUtilisateur($this->getUser());
            $manager->persist($pointage);
            $manager->flush();
        }  
        //Déclarer un incident
        if(!$incident){
            $incident = new Incident();
        }
        $formDeclareIncident = $this->createForm(IncidentType::class,$incident);
        $formDeclareIncident->handleRequest($request);
        if ($formDeclareIncident->isSubmitted() && $formDeclareIncident->isValid()) {
            $incident->setUtilisateur($this->getUser());
            $incident->setDateIncident(new \DateTime());
            $manager->persist($incident);
            $manager->flush();
        }
        //Liste des livraisons
        $allDeliver = $livraisonRepository->findByJour(new \DateTime());
        //J'ai fin ma journée
    
        return $this->render('utilisateur/chauffeur.html.twig',['form'=>$form->createView(),
        'formMakeScore'=>$formMakeScore->createView(),
        'formDeclareIncident'=>$formDeclareIncident->createView(),
        'livraisons'=>$allDeliver]);
    }
    //impressions des livraisons par le chauffeur
    /**
     * @Route("/liste", name="imprimer")
     */
    public function imprimer(DepartRepository $departRepo,PointageRepository $pointageRepo,LivraisonRepository $livraisonRepo)
    {
        // Configure Dompdf according to your needs
        $livre = 0;
        $livraisonToDo = 0;
        $aLivre = $livraisonRepo->findByJour(new \DateTime());
        //$livraisonToDo = count($aLivre);
        $departDuJour = $departRepo->findByJour(new \DateTime());
        $pointage = $pointageRepo->findByJour(new \DateTime());
        $pdfOptions = new Options();
        $pdfOptions->set(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        
         // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('listeLivraison.html.twig', [
            'pointages' => $pointage,'livre'=>$livre, 'aLivre'=>$aLivre,'departs'=>$departDuJour,'livraisonToDo'=> $livraisonToDo
        ]);
        
         // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
         // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

         // Render the HTML as PDF
        $dompdf->render();

         // Output the generated PDF to Browser (force download)
         $dompdf->stream('Livraison de '.$this->getUser()->getLogin().'.pdf', [
             "Attachment" => false
          ]);
    }
    /**
     * @Route("/finish",name="finish")
     */
    public function finish(DepartRepository $departRepo, EntityManagerInterface $manager){
        $livreurDepart = $departRepo->findOneByUtilisateurByJour($this->getUser(),date("Y-m-d"));
        $vehicule = $livreurDepart[0]->getVehicule();
        // renseignement de l'heure de retour de l'usine
        if ($livreurDepart[0]->getHeureRetour() == null) {
            $livreurDepart[0]->setHeureRetour(new \DateTime());
            // modification du statut du véhicule
            $vehicule = $livreurDepart[0]->getVehicule();
            $vehicule->setEtat("libre");
            $manager->persist($this->getUser());
            $manager->persist($vehicule);
        }else{
            $manager->persist($this->getUser());
            $manager->persist($vehicule);
        }
        
        $manager->flush();
        return $this->redirectToRoute("imprimer");
    }
    //----------------------------------Déconnexion de l'utilisateur--------------------------------//
    /**
     * @Route("/logout", name="userDisconnect")
     */
    public function logout(){}
}
