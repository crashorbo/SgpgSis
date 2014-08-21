<?php

namespace Sgpg\BackendBundle\Tests\Entity;

use Sgpg\EstudianteBundle\Entity\Estudiante;

class ClienteTest extends \PHPUnit_Framework_TestCase
{
    public function testNombres()
    {
        $estudiante = new Estudiante();

        $this->assertEquals('Paola', $estudiante->setNombres('Paola'));
    }

    public function testApPaterno()
    {
        $estudiante = new Estudiante();
        $this->assertEquals('Cleyder', $estudiante->setApPaterno('Cleyder'));
    }

    public function testApMaterno()
    {
        $estudiante = new Estudiante();
        $this->assertEquals('Alvarez', $estudiante->setApMaterno('Alvarez'));
    }

    public function testCi()
    {
        $estudiante = new Estudiante();
        $this->assertEquals('1111111', $estudiante->setCi('1111111'));
    }

    public function testTelefono()
    {
        $estudiante = new Estudiante();
        $this->assertEquals('5250000', $estudiante->setTelefono('5250000'));
    }

    public function testCelular()
    {
        $estudiante = new Estudiante();
        $this->assertEquals('72490000', $estudiante->setCelular('72490000'));
    }

    public function testEmail()
    {
        $estudiante = new Estudiante();
        $this->assertEquals('usuario@gmail.com', $estudiante->setCelular('usuario@gmail.com'));
    }
}