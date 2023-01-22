<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('noms', TextType::class, [
                'label' => "Nom(s)",
                'attr' => ['placeholder' => "nom(s)"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('prenoms', TextType::class, [
                'label' => "Prénom(s)",
                'attr' => ['placeholder' => "prénom(s)"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('genre', ChoiceType::class, [
                'label' => "Genre",
                'choices'  => [
                    'Homme'    =>  'Homme',
                    'Femme' =>  'Femme',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Quel est le genre de cet utilisateur?',
                    ]),
                ],
            ])
            ->add('biographie')
            ->add('imageFile', FileType::class, [
                'label' => 'Photo (png, jpg et jpeg)',
                'required'  =>  false,
            ])
            ->add('roles', ChoiceType::class, [
                'label' => "Rôle",
                'choices'  => [
                    'Modérateur'    =>  'ROLE_MODERATEUR',
                    'Administrateur' =>  'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Quel est le role de cet utilisateur?',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
