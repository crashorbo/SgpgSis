<?php

namespace Sgpg\EstudianteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProyectoModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')
                ->add('descripcion','textarea')
                ->add('especialidad', 'entity', array(
                    'class' => 'DocenteBundle:Especializacion',
                    'property' => 'nombre'))
                ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sgpg\EstudianteBundle\Model\ProyectoModel'
        ));
    }

    public function getName()
    {
        return 'type_proyectomodel';
    }
}