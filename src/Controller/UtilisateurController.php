<?php

namespace App\Controller;

use App\Entity\Depart;
use App\Form\DepartType;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\VehiculeRepository;
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
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null,"Vos droits ne sont pas suffisant pour acceder à cette partie");
        return $this->render('utilisateur/admin.html.twig');
    }
    //----------------------------------Espace réservé au chauffeur------------------------------------//
    /**
     * @Route("/chauffeur", name="chauffeur")
     */
    public function chauffeur(Request $request){
        return $this->render('utilisateur/chauffeur.html.twig',['form'=>$form->createView()]);
    }
    //----------------------------------Déconnexion de l'utilisateur--------------------------------//
    /**
     * @Route("/logout", name="userDisconnect")
     */
    public function logout(){}
}
