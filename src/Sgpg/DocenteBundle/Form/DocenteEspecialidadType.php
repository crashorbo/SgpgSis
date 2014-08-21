<?php

namespace Sgpg\DocenteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sgpg\DocenteBundle\Form\EventListener\AddEspecialidadFieldSubscriber;
use Sgpg\DocenteBundle\Form\EventListener\AddCarreraFieldSubscriber;

class DocenteEspecialidadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $factory = $builder->getFormFactory();
        $carreraSubscriber = new AddCarreraFieldSubscriber($factory);
        $builder->addEventSubscriber($carreraSubscriber);
        $especialidadSubscriber = new AddEspecialidadFieldSubscriber($factory);
        $builder->addEventSubscriber($especialidadSubscriber);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sgpg\DocenteBundle\Model\DocenteEspModel'
        ));
    }

    public function getName()
    {
        return 'docenteesp';
    }
}