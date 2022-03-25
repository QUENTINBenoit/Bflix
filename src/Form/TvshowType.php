<?php

namespace App\Form;


use App\Entity\Tvshow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TvshowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                null,
                [
                    'label' => 'Nom de la catégorie '
                ]
            )
            ->add('synopsis')
            ->add('image')
            ->add('nbLikes')
            ->add('publishedAt')
            ->add('createdAt')
            ->add('udaptedAt')
            ->add('characters', \null)
            ->add('catgoriess', \null)
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tvshow::class,
        ]);
    }
}
