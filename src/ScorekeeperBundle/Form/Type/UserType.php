<?php

namespace ScorekeeperBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', 'Symfony\Component\Form\Extension\Core\Type\TextType', array('disabled' => true))
                ->add('name', 'Symfony\Component\Form\Extension\Core\Type\TextType', array('disabled' => true))
                ->add('email', 'Symfony\Component\Form\Extension\Core\Type\TextType', array('disabled' => true))
                ->add('isActive', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array('disabled' => true))
                ->add('plainPassword', 'Symfony\Component\Form\Extension\Core\Type\PasswordType', array('mapped' => false))
                ->add('plainPassword2', 'Symfony\Component\Form\Extension\Core\Type\PasswordType', array('mapped' => false))
                ->add('save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' => 'Submit'));
    }

//    public function getName() {
//        return 'user';
//    }

    public function getBlockPrefix() {
        return 'user';
    }

//    public function setDefaultOptions(OptionsResolverInterface $resolver) {
//        $resolver->setDefaults(array(
//            'data_class' => 'ScorekeeperBundle\Entity\User',
//        ));
//    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ScorekeeperBundle\Entity\User',
        ));
    }

}
