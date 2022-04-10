<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'border border-danger'
                ],
                'label' => 'e-mail',
                'constraints' => new NotBlank([
                    'message' => 'Veuillez entrer un e-mail',
                ])

            ])
            ->add('firstname')
            ->add('lastname')
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-outline-danger btn-sm rounded-pill'
                ]
            ])

            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) {
                    $form = $event->getForm();
                    $userData = $event->getData();
                    //\dd($userData->getRoles());
                    if ($userData->getRoles()[0] === 'ROLE_SUPER_ADMIN') {

                        $form->add('roles', ChoiceType::class, [
                            'choices' => [
                                'Super Administrateur' => 'ROLE_SUPER_ADMIN',
                                'Administrateur' => 'ROLE_ADMIN',
                                'Editeur' => 'ROLE_EDITOR',
                            ],
                            'multiple' => true,
                            'expanded' => true,

                        ]);
                    }
                },
            )
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) {
                    // Avant construction du formulaire, on va d'abord vérifier dans
                    // quel contexte on se trouve :
                    // - Création : on rendra obligatoire la saisie d'un mot de passe
                    // - Edition : la saisie du mot de passe sera facultative
                    $userData = $event->getData();
                    $form = $event->getForm();

                    $userData->getId() === \null ? $required = \true : $required = \false;
                    // if ($userData->getId() === null) {
                    //     // Mode création
                    //     // Le mot de passe sera obligatoire
                    //     // J'ajoute dynamiquement le champ Password
                    //     // Qui est obligatoire en création
                    //     // et optionnel en édition
                    //     $required = true;
                    // } else {
                    //     $required = false;
                    // }
                    $form->add('password', PasswordType::class, [
                        'required' => $required,
                        // 'mapped' => false,
                    ]);
                }

            );
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
