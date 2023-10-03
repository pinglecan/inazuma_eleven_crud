<?php

namespace App\Form;

use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Team;

class CharacterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'attr' => array(
                    'class' => 'bg-tranparent block border-b-2 w-full h-20 text-6xl outline-none',
                    'placeholder' => 'Enter Title...'
                ),
                'label' => false
            ])


            ->add('posision', ChoiceType::class,[
                'attr' => array(
                    'class' => 'bg-tranparent block border-b-2 w-full h-20 text-6xl outline-none',
                    'placeholder' => 'Enter posision...'
                ),
                'choices'  => [
                    'forward (FW)' => 'FW',
                    'midfielder (MF)' => 'MF',
                    'defender (DF)' => 'DF',
                    'goalkeeper (GK)' => 'GK'
                ],
            ])
            ->add('gender', ChoiceType::class,[
                'attr' => array(
                    'class' => 'bg-tranparent block border-b-2 w-full h-20 text-6xl outline-none',
                    'placeholder' => 'Enter gender...'
                ),
                'choices'  => [
                    'male' => 'male',
                    'female' => 'female',
                    'femboy'=> 'femboy'
                ],
            ])

            
            ->add('image', FileType::class, array(
                'required' => false,
                'mapped' => false
            ))
            ->add('teams', EntityType::class,[
                'class' => team::class,
                'choice_label' => 'name',
                'multiple' => true,
                'by_reference' => false
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
