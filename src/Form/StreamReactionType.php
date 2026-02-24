<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\StreamReaction;

class StreamReactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
         $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'J’aime' => 'J’aime',
                    'J’adore' => 'J’adore',
                    'Bravo' => 'Bravo',
                    'Commentaire' => 'Commentaire'
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('comment', TextareaType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Votre commentaire ici…']
            ])
            ->add('username', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Votre nom (optionnel)']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StreamReaction::class, // <-- lie le formulaire à l'entité
        ]);
    }
}