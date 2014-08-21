<?php

namespace Sgpg\DocenteBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class DocenteEspModel
{
    /**
     * @Assert\Type("Sgpg\DocenteBundle\Entity\Especializacion")
     * @Assert\NotNull()
     */
    public $especialidad;

}