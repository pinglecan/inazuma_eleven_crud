<?php

namespace App\Form;

use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Character;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TeamFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'attr' => array(
                    'class' => 'bg-tranparent block border-b-2 w-full h-20 text-6xl outline-none',
                    'placeholder' => 'Enter Title...'
                ),
                'label' => false
            ])

            ->add('image', FileType::class, array(
                'required' => false,
                'mapped' => false
            ))

            ->add('characters', EntityType::class,[
                'class' => Character::class,
                'choice_label' => 'title',
                'multiple' => true,
                'by_reference' => false
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
