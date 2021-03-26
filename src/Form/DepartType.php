<?php

namespace App\Form;

use App\Entity\Depart;
use App\Entity\Vehicule;
use App\Entity\Utilisateur;
use App\Repository\VehiculeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class DepartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jour',DateType::class,['widget' => 'single_text','format' => 'yyyy-MM-dd','disabled' => true, 'data'=> new \DateTime("now")])
            ->add('heureDepart',TimeType::class,['label' => 'Heure de départ','disabled' => true, 'data'=> new \DateTime("now"),'attr'=>['class'=>'col-sm-6']])
            ->add('vehicule',EntityType::class,['class'=>Vehicule::class,'choice_label'=>'immatriculation','label' => 'Véhicule',
            'query_builder'=>function(VehiculeRepository $vehicule){
                return $vehicule->createQueryBuilder('v')
                                ->where('v.etat = :etat')
                                ->setParameter('etat','libre');
                            }])
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
