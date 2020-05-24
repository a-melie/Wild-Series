<?php

namespace App\Form;

use App\Entity\Program;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Titre'])
            ->add('summary', null, ['label'=> 'Résumé'])
            ->add('poster',null, ['label'=> 'Affiche'])
            ->add('country',null, ['label'=> 'Pays'])
            ->add('year',null, ['label'=> 'Année'])
            ->add('category', null, ['choice_label' => 'name', 'label'=>'Catégorie'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
