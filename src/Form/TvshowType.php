<?php

namespace App\Form;

use App\Entity\Tvshow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TvshowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('synopsis')
            ->add('image')
            ->add('nbLikes')
            ->add('publishedAt')
            ->add('createdAt')
            ->add('udaptedAt')
            ->add('slug')
            ->add('characters')
            ->add('catgoriess')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tvshow::class,
        ]);
    }
}
