<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Titre de l'évenement",
                'attr' => ['placeholder' => "Titre"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('imageFile', FileType::class, [
                'attr'  =>  ['class' => ''],
                'label'     =>  'Joindre une image (png, jpg, jpeg)',
                'required'  =>  false,
            ])
            ->add('videoId', TextType::class, [
                'label' => "Identifiant de la vidéo youtube",
                'attr' => ['placeholder' => "ID"],
                'required' => false,
            ])
            ->add('link', TextType::class, [
                'label' => "Lien (zoom, meet...)",
                'attr' => ['placeholder' => "URL"],
                'required' => false,
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'contenu',
                'config' => array(
                    'uiColor' => '#ffffff',
                ),
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ])
                ],
            ])
            ->add('startAt', DateType::class, [
                'label'     =>  'Date de début',
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Quelle est la date de debut de cet événement?',
                    ])
                ],
            ])
            ->add('endAt', DateType::class, [
                'label'     =>  'Date de fin',
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Quelle est la date de fin de cet événement?',
                    ])
                ],
            ])
            ->add('heureDebut', TimeType::class, [
                'label'     =>  'Heure de debut',
                'widget' => 'single_text'
            ])
            ->add('heureFin', TimeType::class, [
                'label'     =>  'Heure de fin',
                'widget' => 'single_text'
            ])
            ->add('online', CheckboxType::class, [
                'label' => "Visible par tous",
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
