<?php

namespace App\Form;

use App\Entity\Depart;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DepartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jour',DateType::class,['widget' => 'single_text','format' => 'yyyy-MM-dd'])
            ->add('heureDepart',DateType::class,['widget' => 'single_text','format' => 'H-i-s'])
            ->add('heureRetour',DateType::class,['widget' => 'single_text','format' => 'H-i-s'])
            ->add('utilisateur',EntityType::class,['class'=>Utilisateur::class,'choice_label'=>'prenom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Depart::class,
        ]);
    }
}
