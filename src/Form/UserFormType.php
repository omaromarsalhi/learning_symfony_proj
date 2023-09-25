<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', CollectionType::class, [
                // each entry in the array will be an "email" field
                'entry_type' => TextType::class,
                // these options are passed to each "email" type
                'entry_options' => [],
            ])
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
