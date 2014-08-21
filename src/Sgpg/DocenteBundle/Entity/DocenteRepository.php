<?php

namespace Sgpg\DocenteBundle\Entity;

use Doctrine\ORM\EntityRepository;

class DocenteRepository extends EntityRepository
{
    public function findRandomDocente()
    {
        $em = $this->getEntityManager();
        $max = $em->createQuery('
            SELECT count(d.id) FROM DocenteBundle:Docente d
            ')->getSingleScalarResult();

        $consulta = $em->createQuery('
            SELECT d
            FROM DocenteBundle:Docente d
            WHERE d.id >= :rand
            ');
        $consulta->setParameter('rand',rand(0,$max));
        $consulta->setMaxResults(1);

        return $consulta->getOneOrNullResult();
    }
}