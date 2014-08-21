<?php

namespace Sgpg\DocenteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class DocenteEspRepository extends EntityRepository
{
    public function findDocenteByEspecialidad($especialidad_id)
    {
        $em = $this->getEntityManager();
        $max = $em->createQuery('
            SELECT MAX(d.id) FROM DocenteBundle:Docente d
            ')->getSingleScalarResult();

        $consulta = $em->createQuery('
            SELECT de
            FROM DocenteBundle:DocenteEspecializacion de
            WHERE de.especializacion = :id AND de.docente >= :rand
            ORDER BY de.docente ASC
            ');
        $consulta->setParameter('rand',rand(0,$max));
        $consulta->setMaxResults(1);
        $consulta->setParameter('id', $especialidad_id);

        return $consulta->getOneOrNullResult();

    }

    public function countByEspecialidad($especialidad_id)
    {
        $em =  $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT count(de.especializacion)
            FROM DocenteBundle:DocenteEspecializacion de
            WHERE de.especializacion = :id
            ');
        $consulta->setParameter('id', $especialidad_id);

        return $consulta->getSingleScalarResult();
    }
}