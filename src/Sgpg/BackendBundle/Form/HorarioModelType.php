<?php

namespace Sgpg\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HorarioModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo','choice', array('choices' => array('REGULAR'   => 'REGULAR',
                                                            'PET'       => 'PET')))
            ->add('dia','choice', array('choices' => array( 'Mon'     => 'Lunes',
                                                            'Tue'    => 'Martes',
                                                            'Wed' => 'Miercoles',
                                                            'Thu'    => 'Jueves',
                                                            'Fri'   => 'Viernes',
                                                            'Sat'    => 'Sabado',
                                                            'Sun'   => 'Domingo')))
            ->add('horaini','time')
            ->add('horafin','time')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sgpg\BackendBundle\Model\HorarioModel'
        ));
    }

    public function getName()
    {
        return 'sgpg_backendbundle_horariomodeltype';
    }
}
