<?php

namespace Sgpg\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EspecializacionModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('carrera', 'entity',array(
                'class' => 'CarreraBundle:Carrera',
                'property' => 'nombre',
                ))
            ->add('nombre')
            ->add('descripcion','textarea')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sgpg\BackendBundle\Model\EspecializacionModel'
        ));
    }

    public function getName()
    {
        return 'sgpg_backendbundle_especializacionmodeltype';
    }
}