<?php

namespace Sgpg\DocenteBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use Sgpg\CarreraBundle\Entity\Carrera;

class AddEspecialidadFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA    => 'preSetData',
            FormEvents::PRE_BIND        => 'preBind'
            );
    }

    private function addEspecialidadForm($form, $especialidad, $carrera)
    {
        $form->add('especialidad', 'entity', array(
            'class'         => 'DocenteBundle:Especializacion',
            'empty_value'   => 'Especialidad',
            'data'          => $especialidad,
            'attr'          => array(
                'class' => 'especialidad_selector',),
            'query_builder' => function(EntityRepository $repository) use ($carrera)
            {
                $qb = $repository->createQueryBuilder('especialidad')
                    ->innerJoin('especialidad.carrera', 'carrera');
                if ($carrera instanceof Carrera)
                {
                    $qb->where('especialidad.carrera = :carrera')
                    ->setParameter('carrera', $carrera->getId());
                } elseif (is_numeric($carrera))
                {
                    $qb->where('carrera.id = :carrera')
                    ->setParameter('carrera', $carrera);
                }else
                {
                    $qb->where('carrera.nombre = :carrera')
                    ->setParameter('carrera', null);
                }

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
        $especialidad = $accessor->getValue($data, 'especialidad');
        $carrera = ($especialidad) ? $especialidad->getCarrera() : null ;
        $this->addEspecialidadForm($form, $especialidad, $carrera);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $carrera = array_key_exists('carrera', $data) ? $data['carrera'] : null;
        $especialidad = array_key_exists('especialidad', $data) ? $data['especialidad'] : null;
        $this->addEspecialidadForm($form, $especialidad, $carrera);
    }
}