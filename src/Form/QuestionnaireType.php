<?php

namespace App\Form;

use App\Entity\Questionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sitMatrimoniale', ChoiceType::class, [
                'label' => "Quelle est votre situation?",
                'choices'  => [
                    'Célibataire'    =>  'Celibataire',
                    'Marié' =>  'Marie',
                    'Divorcé' =>  'Divorce',
                    'Cohabitant légal' =>  'Cohabitant-legal',
                    'Veuf(ve)' =>  'Veuf-ve',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('age', NumberType::class, [
                'label' => 'Quel est votre Âge',
                'attr' => ['placeholder' => ''],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('nbrEnfantsCharge', NumberType::class, [
                'label' => 'Combien d’enfants à charge avez-vous?',
                'attr' => ['placeholder' => ''],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('sitLogement', ChoiceType::class, [
                'label' => "Logement, vous êtes",
                'choices'  => [
                    'Propriétaire'    =>  'Proprietaire',
                    'Locataire' =>  'Locataire',
                    'Hebergé(e) gratuitement' =>  'Heberge-gratuitement',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('activite', ChoiceType::class, [
                'label' => "Quel est votre activité?",
                'choices'  => [
                    'Salarié'    =>  'Salarier',
                    'Indépendant(e) / Dirigeant' =>  'Independant-dirigeant',
                    'Etudiant(e)' =>  'Etudiant',
                    'Au chômage / Sans activité' =>  'au-chomage-sans-activite',
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('revNetMensuels', NumberType::class, [
                'label' => 'Quels sont vos revenus net Mensuels?',
                'attr' => ['placeholder' => ''],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => "prénom"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => "Nom"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Exemple@domail.com'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                    new Email([
                        'message' => 'Veuillez saisir une adresse email valide',
                    ]),
                ],
            ])
            ->add('codePostal', NumberType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Code postal'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
            ->add('telephone', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => "Téléphone"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Questionnaire::class,
        ]);
    }
}
