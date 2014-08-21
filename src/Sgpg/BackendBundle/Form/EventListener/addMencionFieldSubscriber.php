<?php

namespace Sgpg\BackendBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use Sgpg\CarreraBundle\Entity\Carrera;

class AddMencionFieldSubscriber implements EventSubscriberInterface
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

    private function addMencionForm($form, $mencion, $carrera)
    {
        $form->add('mencion', 'entity', array(
            'class'         => 'CarreraBundle:Mencion',
            'empty_value'   => 'Mencion',
            'data'          => $mencion,
            'attr'          => array(
                'class' => 'mencion_selector',),
            'query_builder' => function(EntityRepository $repository) use ($carrera)
            {
                $qb = $repository->createQueryBuilder('mencion')
                    ->innerJoin('mencion.carrera', 'carrera');
                if ($carrera instanceof Carrera)
                {
                    $qb->where('mencion.carrera = :carrera')
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
        $mencion = $accessor->getValue($data, 'mencion');
        $carrera = ($mencion) ? $mencion->getCarrera() : null ;
        $this->addMencionForm($form, $mencion, $carrera);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $carrera = array_key_exists('carrera', $data) ? $data['carrera'] : null;
        $mencion = array_key_exists('mencion', $data) ? $data['mencion'] : null;
        $this->addMencionForm($form, $mencion, $carrera);
    }
}