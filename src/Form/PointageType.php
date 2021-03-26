<?php

namespace App\Form;

use App\Entity\Pointage;
use App\Entity\Livraison;
use App\Entity\Utilisateur;
use App\Repository\LivraisonRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PointageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {  
        $builder
            ->add('heureArrivee',TimeType::class,['label'=>"Heure d'arrivée"])
            ->add('heurSortie',TimeType::class,['label'=>"Heure de sortie"])
            ->add('livraison',EntityType::class,['class'=>Livraison::class,'choice_label'=>'libelle','label'=>'Point de Livraison',
            'query_builder' => function (LivraisonRepository $livraison) {
                return $livraison->createQueryBuilder('u')
                ->where('u.statut = :livraison')
                ->setParameter('livraison','attente');
            }])
            ->add('commentaire',TextareaType::class)
            ->add('Démarrer',SubmitType::class,['label'=>'Valider la tournée'])
            ->add('Effacer',ResetType::class,['label'=>'Effacer les données'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pointage::class,
        ]);
    }
}
