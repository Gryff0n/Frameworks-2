<?php
namespace App\Form;

use App\Entity\Cours;
use App\Entity\Formation;
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}