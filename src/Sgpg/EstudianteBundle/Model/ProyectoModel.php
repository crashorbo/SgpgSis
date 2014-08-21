<?php

namespace Sgpg\EstudianteBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ProyectoModel
{
    /**
     * @Assert\NotBlank()
     */
    public $nombre;

    /**
     * @Assert\NotBlank()
     */
    public $descripcion;

    /**
     * @assert\Type("Sgpg\DocenteBundle\Entity\Especializacion")
     * @Assert\NotBlank()
     */
    public $especialidad;
}