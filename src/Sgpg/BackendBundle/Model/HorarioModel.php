<?php

namespace Sgpg\BackendBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class HorarioModel
{
    /**
     * @Assert\NotBlank()
     */
    public $tipo;

    /**
     * @Assert\NotBlank()
     */
    public $dia;

    /**
     * @Assert\NotBlank()
     */
    public $horaini;

    /**
     * @Assert\NotBlank()
     */
    public $horafin;

}