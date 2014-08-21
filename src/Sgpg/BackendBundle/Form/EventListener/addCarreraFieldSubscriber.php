<?php

namespace Sgpg\BackendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddCarreraFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_BIND     => 'preBind'
        );
    }

    private function addCarreraForm($form, $carrera)
    {
        $form->add('carrera', 'entity', array(
            'class'         => 'CarreraBundle:Carrera',
            'mapped'        => false,
            'data'          => $carrera,
            'empty_value'   => 'Carrera',
            'attr'          => array(
                'class' => 'carrera_selector',
            ),
            'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('carrera');

                return $qb;
            }
        ));
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::getPropertyAccessor();
        $mencion = $accessor->getValue($data, 'mencion');
        $carrera = ($mencion) ? $mencion->getCarrera() : null ;
        $this->addCarreraForm($form, $carrera);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $carrera = array_key_exists('carrera', $data) ? $data['carrera'] : null;
        $this->addCarreraForm($form, $carrera);
    }
}
