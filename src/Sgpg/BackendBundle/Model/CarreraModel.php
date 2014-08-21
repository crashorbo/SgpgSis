<?php

namespace Sgpg\BackendBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CarreraModel
{
    /**
     * @Assert\NotBlank()
     */
    public $nombre;

    /**
     * @Assert\NotBlank()
     */
    public $descripcion;

}