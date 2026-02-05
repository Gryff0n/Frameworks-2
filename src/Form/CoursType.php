<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Formation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('semestre')
            ->add('Description')
            ->add('ECTS')
            ->add('heureCM')
            ->add('heureTD')
            ->add('heureTP')
            ->add('formations', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => function(Formation $formation) {
                    return $formation->getNiveau() . ' ' . $formation->getIntitule() . ' - ' . $formation->getParcours();
                },
                'multiple' => true,
                'expanded' => false,
                'attr' => ['class' => 'form-select', 'size' => 5],
                'label' => 'Formations',
            ])
            ->add('responsable', EntityType::class, [
                'class' => User::class,
                'choice_label' => function(User $user) {
                    return $user->getPrenom() . ' ' . $user->getNom() . ' (' . $user->getGrade() . ')';
                },
                'placeholder' => 'Sélectionner un responsable',
                'required' => false,
                'attr' => ['class' => 'form-select'],
                'label' => 'Responsable du cours',
            ])
            ->add('enseignants', EntityType::class, [
                'class' => User::class,
                'choice_label' => function(User $user) {
                    return $user->getPrenom() . ' ' . $user->getNom() . ' (' . $user->getGrade() . ')';
                },
                'multiple' => true,
                'expanded' => false,
                'attr' => ['class' => 'form-select', 'size' => 5],
                'label' => 'Enseignants',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}