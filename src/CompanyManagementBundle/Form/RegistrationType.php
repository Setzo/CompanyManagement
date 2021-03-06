<?php

namespace CompanyManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email', 'email')
//            ->add('password', 'repeated', array(
//                'first_options'  => array('label' => 'Password'),
//                'second_options' => array('label' => 'Repeat Password'),
//                'type' => 'password'
//            ))
            ->add('dateAdded', 'datetime')
            ->add('address')
            ->add('zipCode')
            ->add('city')
            ->add('telephone')
            ->add('hourlyRate')
            ->add('company')
            ->add('department')
            ->add('managedDepartment')
            ->add('role');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}