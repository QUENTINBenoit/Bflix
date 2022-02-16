<?php

namespace App\Form;

use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
                'label' => 'Prenom',
                'constraints' => new NotBlank([
                    'message' => 'Veuillez saisir un Prenom'
                ])
            ])
            ->add(
                'gender',
                TextType::class,
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
