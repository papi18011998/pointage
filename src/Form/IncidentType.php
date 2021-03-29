<?php

namespace App\Form;

use App\Entity\Incident;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateIncident')
            ->add('heureIncident')
            ->add('commentaire')
            ->add('utilisateur',EntityType::class,['class'=>Utilisateur::class,
            'choice_label'=>function($utilisateur){
                return $utilisateur->getPrenom();
            }])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Incident::class,
        ]);
    }
}
