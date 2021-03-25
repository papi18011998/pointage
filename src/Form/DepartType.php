<?php

namespace App\Form;

use App\Entity\Depart;
use App\Entity\Vehicule;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class DepartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jour',DateType::class,['widget' => 'single_text','format' => 'yyyy-MM-dd','disabled' => true, 'data'=> new \DateTime("now")])
            ->add('heureDepart',DateTimeType::class,['date_label' => 'Heure de départ','disabled' => true, 'data'=> new \DateTime("now")])
            ->add('utilisateur',EntityType::class,['class'=>Utilisateur::class,'disabled' => true,
            'choice_label' => function($utilisateur, $key, $index) {
                /** @var Utilisateur $utilisateur */
                return $utilisateur->getPrenom() . ' ' . $utilisateur->getNom();
            }])
            ->add('vehicule',EntityType::class,['class'=>Vehicule::class,'choice_label'=>'immatriculation'])
            ->add('Démarrer',SubmitType::class,['label'=>'Démarrer la journée'])
            ->add('Effacer',ResetType::class,['label'=>'Effacer les données'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Depart::class,
        ]);
    }
}
