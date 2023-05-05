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
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use DateTime;
use Symfony\Component\Validator\Constraints\File;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => [
                    'placeholder' => 'Your pseudo',
                ],
                'label' => 'Pseudo',
            ])
            ->add('email', EmailType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
                'attr' => [
                    'placeholder' => 'Your email address',
                ],
                'label' => 'Email',
            ])
            ->add('note', IntegerType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => [
                    'placeholder' => 'Your note between 1 and 5',
                ],
                'label' => 'Note',
            ])
            ->add('opinion', TextType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => [
                    'placeholder' => 'Your opinion',
                ],
                'label' => 'Opinion',
            ])
            ->add('image', TextType::class, [
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Your image',
                ],
                'label' => 'Image',
            ])
            ->add('date', DateTimeType::class, [
                'mapped' => false,
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'html5' => false,
                'label' => 'Date',
                'data' => new DateTime(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}