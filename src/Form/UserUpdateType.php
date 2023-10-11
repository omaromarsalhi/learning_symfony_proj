<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\Entities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            // ->add('password')
            ->add('email', EmailType::class, [
                'constraints' =>
                [
                    // new NotBlank(),
                    // new Email(),
                    // new Entities()
                ]
            ])
            ->add('age')
            ->add('cin')
            ->add('image', FileType::class, [
                'required' => false,
                'mapped' => false
            ])

            ->add('Save', SubmitType::class, [
                'label' => 'Save',
                'attr' => array('style' => 'float: left')
            ])
            ->add('Cancel', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-danger ms-4'
                ],
                'label' => 'Cancel'
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
