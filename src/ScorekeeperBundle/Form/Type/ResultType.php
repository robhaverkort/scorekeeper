<?php

namespace ScorekeeperBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResultType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                //->add('contest','entity',array('class'=>'ScorekeeperBundle:Contest','property'=>'id'))
                ->add('user', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array('class' => 'ScorekeeperBundle:User', 'choice_label' => 'name', 'placeholder' => ''))
                //->add('details', 'text')
                ->add('s10', 'Symfony\Component\Form\Extension\Core\Type\TextType', array('mapped' => false, 'required' => false, 'attr' => array('maxlength' => 2, 'size' => 3, 'onInput' => 'calctotal();')))
                ->add('s09', 'Symfony\Component\Form\Extension\Core\Type\TextType', array('mapped' => false, 'required' => false, 'attr' => array('maxlength' => 2, 'size' => 3, 'onInput' => 'calctotal();')))
                ->add('s08', 'Symfony\Component\Form\Extension\Core\Type\TextType', array('mapped' => false, 'required' => false, 'attr' => array('maxlength' => 2, 'size' => 3, 'onInput' => 'calctotal();')))
                ->add('s07', 'Symfony\Component\Form\Extension\Core\Type\TextType', array('mapped' => false, 'required' => false, 'attr' => array('maxlength' => 2, 'size' => 3, 'onInput' => 'calctotal();')))
                ->add('s06', 'Symfony\Component\Form\Extension\Core\Type\TextType', array('mapped' => false, 'required' => false, 'attr' => array('maxlength' => 2, 'size' => 3, 'onInput' => 'calctotal();')))
                ->add('total', 'Symfony\Component\Form\Extension\Core\Type\TextType', array('attr' => array('maxlength' => 3, 'size' => 4, 'onInput' => 'cleardetails();')))
                ->add('save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array('label' => 'Add'));
    }

    public function getName() {
        return 'result';
    }

//    public function configureOptions(Symfony\Component\OptionsResolver\OptionsResolver $resolver) {
//    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ScorekeeperBundle\Entity\Result',
        ));
    }

}
