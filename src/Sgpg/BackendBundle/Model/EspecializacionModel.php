<?php

namespace Sgpg\BackendBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class EspecializacionModel
{
    /**
     * @assert\Type("Sgpg\CarreraBundle\Entity\Carrera")
     */
    public $carrera;

    /**
     * @Assert\NotBlank()
     */
    public $nombre;

    /**
     * @Assert\NotBlank()
     */
    public $descripcion;

}