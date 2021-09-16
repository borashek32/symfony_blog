<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('img', TextType::class, [
                'label' => 'Image',
                'attr'  => [
                    'placeholder' => 'Enter link to image',
                    'class'       => 'form-control mb-3'
                ]
            ])
            ->add('category', EntityType::class, [
                'label'        => 'Category',
                'class'        => Category::class,
                'choice_label' => 'title',
                'choice_value' => 'id',
                'attr'         => [
                    'placeholder' => 'Choose category',
                    'class'       => 'form-select mb-3'
                ]
            ])
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr'  => [
                    'placeholder' => 'Enter title',
                    'class'       => 'form-control mb-3'
                ]
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Text',
                'attr'  => [
                    'placeholder' => 'Enter some text',
                    'class'       => 'form-control mb-3',
                    'rows'        => '10'
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
