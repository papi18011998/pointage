<?php

namespace App\Form;

use App\Entity\Pointage;
use App\Entity\Livraison;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PointageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('utilisateur', EntityType::class,['class'=>Utilisateur::class,
              'choice_label'=> function($utilisateur){
               return $utilisateur->getPrenom().' '.$utilisateur->getNom(); 
               },'disabled'=>true])
            ->add('heureArrivee')
            ->add('heurSortie')
            ->add('PointDeLivraison')
            ->add('commentaire')
            ->add('livraison',EntityType::class,['class'=>Livraison::class,'choice_label'=>'libelle'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pointage::class,
        ]);
    }
}
