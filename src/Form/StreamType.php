<?php

// src/Form/StreamType.php
namespace App\Form;

use App\Entity\Stream;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class StreamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('videoFile', FileType::class, [
                'label' => 'Vidéo',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '500M',
                        'mimeTypes' => ['video/mp4', 'video/webm'],
                        'mimeTypesMessage' => 'Uploader une vidéo mp4 ou webm valide',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Stream::class]);
    }
}
