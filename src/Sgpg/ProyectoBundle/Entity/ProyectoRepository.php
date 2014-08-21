<?php

namespace Sgpg\ProyectoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProyectoRepository extends EntityRepository
{
    public function findProyectoByPostulante($postulante_id)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('
            SELECT p
            FROM ProyectoBundle:Proyecto p
            WHERE p.estudiante = :id AND p.activo = :activo
            ');
        $consulta->setParameter('id', $postulante_id);
        $consulta->setParameter('activo', true);
        $consulta->setMaxResults(1);

        return $consulta->getOneOrNullResult();
    }
}