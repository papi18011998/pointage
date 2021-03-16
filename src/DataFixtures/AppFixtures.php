<?php

namespace App\DataFixtures;

use App\Entity\Role;
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
            $utilisateur->setPrenom("Papa Ibrahima")
                        ->setNom("NDIAYE")
                        ->setLogin("papi")
                        ->setPassword($this->encoder->encodePassword($utilisateur,"Passer@1"))
                        ->setTelephone("776692537")
                        ->setRole($role);
            $manager->persist($utilisateur);
        $manager->flush();
    }
}
