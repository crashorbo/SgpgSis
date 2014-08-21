<?php

namespace Sgpg\BackendBundle\Form;

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
