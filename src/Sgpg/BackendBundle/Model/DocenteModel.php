<?php

namespace Sgpg\BackendBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class DocenteModel
{
    /**
     * @Assert\Type("Sgpg\CarreraBundle\Entity\Carrera")
     * @Assert\NotNull()
     */
    public $carrera;

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
     * @Assert\Length(min = "7", max = "7")
     */
    public $ci;

    public $password;

}