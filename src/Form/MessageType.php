<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' =>  'Nom',
                'attr'  =>  ['placeholder'   =>  'Nom(s)'],
                'constraints'   =>  [
                    new NotBlank([
                        'message'   =>  'Ce champ est requis'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' =>  'Email',
                'attr'  =>  ['placeholder'   =>  'Votre adresse Email...'],
                'constraints'   =>  [
                    new NotBlank([
                        'message'   =>  'Quelle est votre adresse email?'
                    ]),
                    new Email([
                        'message'   =>  'Veuillez saisir une adresse Email valide'
                    ])
                ]
            ])
            ->add('sujet', TextType::class, [
                'label' =>  'Sujet',
                'attr'  =>  ['placeholder'   =>  'Pour quelle raison souhaitez-vous nous contacter?'],
                'constraints'   =>  [
                    new NotBlank([
                        'message'   =>  'Pour quelle raison souhaitez-vous nous contacter?'
                    ])
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' =>  'Message',
                'attr'  =>  ['placeholder'   =>  'Ecrire le message...'],
                'constraints'   =>  [
                    new NotBlank([
                        'message'   =>  'Veuillez écrire un message!'
                    ]),
                    new Length([
                        'min'   =>  10,
                        'minMessage'    =>  'Votre message doit faire au minimum 10 caractères',
                        'max'   =>  500,
                        'maxMessage'    =>  'Votre message doit faire au maximum 500caractères'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => Message::class,
        ]);
    }
}
