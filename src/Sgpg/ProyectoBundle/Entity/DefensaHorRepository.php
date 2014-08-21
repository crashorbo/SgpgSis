<?php

namespace Sgpg\ProyectoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class DefensaHorRepository extends EntityRepository
{
    public function encontrarFecha($fecha, $horario_id)
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('
            SELECT dh
            FROM ProyectoBundle:DefensaHorario dh
            WHERE dh.fecha = :fecha AND dh.horario = :horario
            ');
        $consulta->setParameter('fecha', $fecha);
        $consulta->setParameter('horario', $horario_id);
        return $consulta->getOneOrNullResult();
    }
}