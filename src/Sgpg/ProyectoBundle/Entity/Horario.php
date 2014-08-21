<?php

namespace Sgpg\ProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Horario
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Horario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=10)
     */
    protected $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="dia", type="string", length=10)
     */
    protected $dia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_inicio", type="time")
     */
    protected $horaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_final", type="time")
     */
    protected $horaFinal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="date")
     */
    protected $fechaCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="date")
     */
    protected $fechaModificacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    protected $estado;

    private function getNombreDia($dia)
    {
        $valor = '';
        switch ($dia) {
            case 'Mon':
                $valor = 'Lunes';
                break;
            case 'Tue':
                $valor = 'Martes';
                break;
            case 'Wed':
                $valor = 'Miercoles';
                break;
            case 'Thu':
                $valor = 'Jueves';
                break;
            case 'Fri':
                $valor = 'Viernes';
                break;
            case 'Sat':
                $valor = 'Sabado';
                break;
            case 'Sun':
                $valor = 'Domingo';
                break;
        }

        return $valor;
    }
    public function __construct()
    {
        $this->setFechaCreacion(new \DateTime());
        $this->setFechaModificacion(new \DateTime());
        $this->setEstado(true);
    }

    public function getActivo()
    {
        if ($this->getEstado())
            return "ACTIVADO";

        return "ELIMINADO";
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dia
     *
     * @param string $dia
     * @return Horario
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return string
     */
    public function getDia()
    {
        return $this->dia;
    }

    public function getDiaReal()
    {
        return $this->getNombreDia($this->getDia());
    }

    /**
     * Set horaInicio
     *
     * @param \DateTime $horaInicio
     * @return Horario
     */
    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    /**
     * Get horaInicio
     *
     * @return \DateTime
     */
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * Set horaFinal
     *
     * @param \DateTime $horaFinal
     * @return Horario
     */
    public function setHoraFinal($horaFinal)
    {
        $this->horaFinal = $horaFinal;

        return $this;
    }

    /**
     * Get horaFinal
     *
     * @return \DateTime
     */
    public function getHoraFinal()
    {
        return $this->horaFinal;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Horario
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Horario
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return Horario
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Horario
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}