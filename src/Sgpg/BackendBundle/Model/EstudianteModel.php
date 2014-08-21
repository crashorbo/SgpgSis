<?php

namespace Sgpg\BackendBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class EstudianteModel
{
    /**
     * @Assert\Type("Sgpg\CarreraBundle\Entity\Mencion")
     * @Assert\NotNull()
     */
    public $mencion;

    /**
     * @Assert\NotBlank()
     */
    public $nombres;

    /**
     * @Assert\NotBlank()
     */
    public $apPaterno;

    /**
     * @Assert\NotBlank()
     */
    public $apMaterno;

    /**
     * @Assert\NotBlank()
     */
    public $tipo;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min = "7", max = "7")
     */
    public $ci;
}