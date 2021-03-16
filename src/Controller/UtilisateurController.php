<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UtilisateurController extends AbstractController
{

    //Espace authentification de l'utilisateur
    /**
     * @Route("/", name="userLogin")
     */
    public function index() {
        if($this->getUser()->getRole()->getLibelle()==="CHAUFFEUR"){
            return $this->redirectToRoute('chauffeur');
        }elseif($this->getUser()->getRole()->getLibelle()==="ADMIN"){
            return $this->redirectToRoute('admin');
        }
         return $this->render('utilisateur/index.html.twig');
       // dd($this->getUser()->getRole()->getLibelle());
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(){
        $this->denyAccessUnlessGranted('ROLE_ADMIN',null,"Vos droits ne sont pas suffisant pour creer un compte");
        return $this->render('utilisateur/admin.html.twig');
    }
    /**
     * @Route("/chauffeur", name="chauffeur")
     */
    public function chauffeur(){
        $this->denyAccessUnlessGranted('ROLE_CHAUFFEUR',null,"Vos droits ne sont pas suffisant pour creer un compte");
        return $this->render('utilisateur/chauffeur.html.twig');
    }
    /**
     * @Route("/logout", name="userDisconnect")
     */
    public function logout(){}
}
