<?php

namespace App\Form;

use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class CharactersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prenom',
                'constraints' => new NotBlank([
                    'message' => 'Veuillez saisir un Prenom'
                ])
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'constraints' => new NotBlank([
                    'message' => 'Veuillez saisir un Prenom'
                ])
            ])
            ->add(
                'gender',
                ChoiceType::class,
                [
                    'placeholder' => 'choisisser un genre',
                    'choices' => [
                        'homme' => 'homme',
                        'femme' => 'femme'
                    ]
                ]
            )
            ->add('bio', \null)
            ->add('age', \null)
            ->add('image', FileType::class, [
                'label' => 'Téléverser une nouvelle image',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k'
                    ])
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn-danger btn'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
