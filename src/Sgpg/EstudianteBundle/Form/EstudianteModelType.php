<?php

namespace Sgpg\DocenteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sgpg\BackendBundle\Form\EventListener\AddMencionFieldSubscriber;
use Sgpg\BackendBundle\Form\EventListener\AddCarreraFieldSubscriber;

class EstudianteModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $factory = $builder->getFormFactory();
        $carreraSubscriber = new AddCarreraFieldSubscriber($factory);
        $builder->addEventSubscriber($carreraSubscriber);
        $mencionSubscriber = new AddMencionFieldSubscriber($factory);
        $builder->addEventSubscriber($mencionSubscriber);
        $builder
            ->add('nombres')
            ->add('apPaterno')
            ->add('apMaterno')
            ->add('tipo', 'choice', array('choices' => array('Regular' => 'Regular', 'PET' => 'PET')))
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
            'data_class' => 'Sgpg\BackendBundle\Model\EstudianteModel'
        ));
    }

    public function getName()
    {
        return 'estudiante';
    }
}
