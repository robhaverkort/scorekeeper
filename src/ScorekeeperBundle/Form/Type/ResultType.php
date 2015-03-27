<?php

namespace ScorekeeperBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResultType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                //->add('contest','entity',array('disabled'=>true, 'class'=>'ScorekeeperBundle:Contest','property'=>'id'))
                ->add('user', 'entity', array('class' => 'ScorekeeperBundle:User', 'property' => 'name'))
                //->add('details', 'text')
                ->add('s10', 'text', array('mapped' => false, 'required' => false, 'attr' => array('maxlength' => 2, 'size' => 3)))
                ->add('s09', 'text', array('mapped' => false, 'required' => false, 'attr' => array('maxlength' => 2, 'size' => 3)))
                ->add('s08', 'text', array('mapped' => false, 'required' => false, 'attr' => array('maxlength' => 2, 'size' => 3)))
                ->add('s07', 'text', array('mapped' => false, 'required' => false, 'attr' => array('maxlength' => 2, 'size' => 3)))
                ->add('s06', 'text', array('mapped' => false, 'required' => false, 'attr' => array('maxlength' => 2, 'size' => 3)))
                ->add('total', 'text', array('attr' => array('maxlength' => 3, 'size' => 4)))
                ->add('save', 'submit', array('label' => 'Add'));
    }

    public function getName() {
        return 'result';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ScorekeeperBundle\Entity\Result',
        ));
    }

}
