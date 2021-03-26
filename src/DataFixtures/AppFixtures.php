<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\Vehicule;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
            $role = new Role();
            $role->setLibelle("CHAUFFEUR");
            $manager->persist($role);
            $utilisateur = new Utilisateur();
            $utilisateur->setPrenom("Djibril")
                        ->setNom("DIEDHIOU")
                        ->setLogin("djibi")
                        ->setPassword($this->encoder->encodePassword($utilisateur,"Passer@1"))
                        ->setTelephone("771234567")
                        ->setRole($role);
            $manager->persist($utilisateur);
            $role1 = new Role();
            $role1->setLibelle("ADMIN");            
            $utilisateur1 = new Utilisateur();
            $utilisateur1->setPrenom("Papa Ibrahima")
                        ->setNom("NDIAYE")
                        ->setLogin("papi")
                        ->setPassword($this->encoder->encodePassword($utilisateur,"Passer@1"))
                        ->setTelephone("776692537")
                        ->setRole($role1);
            $manager->persist($role1);
            $manager->persist($utilisateur1);
            // Ajout des véhicules
            $vehicule = new Vehicule();
            $vehicule->setMarque("Peugeot")
                     ->setModele("Partner")
                     ->setImmatriculation("DK-1234-AL")
                     ->setEtat('libre');
            $manager->persist($vehicule);
            $vehicule1 = new Vehicule();
            $vehicule1->setMarque("Peugeot")
                     ->setModele("Partner")
                     ->setImmatriculation("TH-5678-BL")
                     ->setEtat('occupé');
            $manager->persist($vehicule1);        
        $manager->flush();
    }
}
