<?php

namespace Sgpg\DocenteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class DocenteModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('carrera', 'entity',array(
                'class' => 'CarreraBundle:Carrera',
                'property' => 'nombre',
            ))
            ->add('nombres')
            ->add('apPaterno')
            ->add('apMaterno')
            ->add('ci')
            ->add('telefono','text', array('required' => false))
            ->add('celular','text', array('required'  => false))
            ->add('email','text', array('required'    => false))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Las dos contraseñas deben coincidir',
                'first_options'   => array('label' => 'Contraseña'),
                'second_options'  => array('label' => 'Repite Contraseña'),
                'required'        => false
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sgpg\DocenteBundle\Model\DocenteModel'
        ));
    }

    public function getName()
    {
        return 'docente';
    }
}