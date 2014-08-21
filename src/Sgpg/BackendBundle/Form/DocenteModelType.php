<?php

namespace Sgpg\BackendBundle\Form;

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
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sgpg\BackendBundle\Model\DocenteModel'
        ));
    }

    public function getName()
    {
        return 'sgpg_docentebundle_docentetype';
    }
}
