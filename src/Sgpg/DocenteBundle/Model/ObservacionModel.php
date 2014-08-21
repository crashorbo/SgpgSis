<?php

namespace Sgpg\DocenteBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ObservacionModel
{
    /**
     * @Assert\NotBlank()
     */
    public $descripcion;
}