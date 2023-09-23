<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles')
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('age')
            ->add('cin')
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
