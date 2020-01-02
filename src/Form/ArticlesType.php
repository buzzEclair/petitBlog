<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Categorys;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('content')
            ->add('urlImg')
            ->add('categorys', EntityType::class, [
                'class' => Categorys::class,
                'choice_label' => 'name'
            ])
            ->add('star', CheckboxType::class, ['label' => 'Mettre l\'article en avant' ,'required' => false])
            ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
