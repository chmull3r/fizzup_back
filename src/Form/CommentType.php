<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class)
            ->add('email', EmailType::class)
            ->add('note', IntegerType::class)
            ->add('opinion', TextType::class)
            ->add('image', FileType::class, [
                'required' => false
            ])
            ->add('date', DateTimeType::class, [
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'html5' => false,
            ])
            ->setMethod('POST')
            ->setAction($options['action'])
            ->setAttributes([
                'enctype' => 'multipart/from-data'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}