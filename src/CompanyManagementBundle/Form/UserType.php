<?php

namespace CompanyManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email', 'email')
            ->add('password', 'repeated', array(
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
                'type' => 'password'
            ))
            ->add('dateAdded', 'datetime')
            ->add('address')
            ->add('zipCode')
            ->add('city')
            ->add('telephone')
            ->add('hourlyRate')
            ->add('company')
            ->add('department')
            ->add('managedDepartment')
            ->add('role')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CompanyManagementBundle\Entity\User'
        ));
    }
}