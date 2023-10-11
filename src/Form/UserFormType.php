<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserPasswrod;
use App\Validator\Entities;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('roles', CollectionType::class, [
            //     // each entry in the array will be an "email" field
            //     'entry_type' => TextType::class,
            //     // these options are passed to each "email" type
            //     'entry_options' => [],
            // ])
            ->add('firstName', TextType::class, ['required' => false])
            ->add('lastName', TextType::class, ['required' => false])
            ->add('password', TextType::class, [
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'constraints' =>
                [
                    new NotBlank(),
                    new Email(),
                    new Entities(),
                ], 'required' => false,
            ])
            ->add('age', NumberType::class, ['required' => false])
            ->add('cin', NumberType::class, ['required' => false])
            ->add('image', FileType::class, [
                'required' => false
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
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
