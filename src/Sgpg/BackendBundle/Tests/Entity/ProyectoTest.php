<?php

namespace Sgpg\BackendBundle\Tests\Entity;

use Sgpg\ProyectoBundle\Entity\Proyecto;

class ProyectoTest extends \PHPUnit_Framework_TestCase
{
    public function testNombre()
    {
        $proyecto = new Proyecto();

        $this->assertEquals('Sistemas', $carrera->setNombre('Sistemas'));
    }

    public function testDescripcion()
    {
        $proyecto = new Proyecto();
        $this->assertEquals('Carrera de Ingeniera en Sistemas', $proyecto->setDescripcion('Carrera de Ingeniera en Sistemas'));
    }

    public function testEstudiante()
    {
        $proyecto = new Proyecto();
        $estudiante = new Estudiante();
        $this->assertEquals($estudiante, $proyecto->setEstudiante($estudiante))
    }

    public function testTutor()
    {
        $proyecto = new Proyecto();
        $docente = new Docente();
        $this->assertEquals($docente, $proyecto->setEstudiante($docente))
    }
}