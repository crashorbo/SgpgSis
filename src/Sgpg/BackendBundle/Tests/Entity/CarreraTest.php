<?php

namespace Sgpg\BackendBundle\Tests\Entity;

use Sgpg\CarreraBundle\Entity\Carrera;

class CarreraTest extends \PHPUnit_Framework_TestCase
{
    public function testNombre()
    {
        $carrera = new Carrera();

        $this->assertEquals('Sistemas', $carrera->setNombre('Sistemas'));
    }

    public function testDescripcion()
    {
        $carrera = new Carrera();
        $this->assertEquals('Carrera de Ingeniera en Sistemas', $carrera->setDescripcion('Carrera de Ingeniera en Sistemas'));
    }

}