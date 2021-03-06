<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Program;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('summary', TextType::class, ['label'=> 'Résumé'])
            ->add('poster',UrlType::class, ['label'=> 'Affiche'])
            ->add('country',TextType::class, ['label'=> 'Pays'])
            ->add('year',IntegerType::class, ['label'=> 'Année'])
            ->add('category', EntityType::class, [
                'class'=>Category::class,
                'choice_label' => 'name',
                'label'        =>'Catégorie'],)
            ->add('actors', EntityType::class, [
                'class'=> Actor::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
                'by_reference' => false,
                'label' =>'Acteurs'],)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
