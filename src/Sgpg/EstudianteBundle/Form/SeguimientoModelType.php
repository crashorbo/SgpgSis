<?php

namespace Sgpg\EstudianteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SeguimientoModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tipo', 'choice', array('choices' => array(
                    'PERFIL' => 'PERFIL', 'BORRADOR'=>'BORRADOR')))
                ->add('archivo','file')
                ->add('descripcion', 'textarea')
                ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sgpg\EstudianteBundle\Model\SeguimientoModel'
        ));
    }

    public function getName()
    {
        return 'type_seguimientomodel';
    }
}