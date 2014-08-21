<?php

namespace Sgpg\EstudianteBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SeguimientoModel
{
    /**
     * @Assert\NotBlank()
     */
    public $tipo;

    /**
     * @Assert\File(
     *     maxSize = "2024k",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     */
    public $archivo;

    /**
     * @Assert\NotBlank()
     */
    public $descripcion;
}