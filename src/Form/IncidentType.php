<?php

namespace App\Form;

use App\Entity\Incident;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class IncidentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('heureIncident')
            ->add('commentaire')
            ->add('Démarrer',SubmitType::class,['label'=>'Démarrer la journée'])
            ->add('Effacer',ResetType::class,['label'=>'Effacer les données'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Incident::class,
        ]);
    }
}
