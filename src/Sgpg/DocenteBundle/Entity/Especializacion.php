<?php

namespace Sgpg\DocenteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Especializacion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Especializacion
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    protected $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    protected $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feha_creacion", type="date")
     */
    protected $fehaCreacion;

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

    /**
     * @ORM\ManyToOne(targetEntity = "Sgpg\CarreraBundle\Entity\Carrera")
     */
    protected $carrera;

    public function __toString()
    {
        return $this->getNombre();
    }

    public function __construct()
    {
        $this->setFehaCreacion(new \DateTime());
        $this->setFechaModificacion(new \DateTime());
        $this->setEstado(true);
    }

    public function getActivo()
    {
        if($this->getEstado())
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
     * Set nombre
     *
     * @param string $nombre
     * @return Especializacion
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Especializacion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fehaCreacion
     *
     * @param \DateTime $fehaCreacion
     * @return Especializacion
     */
    public function setFehaCreacion($fehaCreacion)
    {
        $this->fehaCreacion = $fehaCreacion;

        return $this;
    }

    /**
     * Get fehaCreacion
     *
     * @return \DateTime
     */
    public function getFehaCreacion()
    {
        return $this->fehaCreacion;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Especializacion
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
     * @return Especializacion
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
     * Set carrera
     *
     * @param \Sgpg\CarreraBundle\Entity\Carrera $carrera
     * @return Especializacion
     */
    public function setCarrera(\Sgpg\CarreraBundle\Entity\Carrera $carrera = null)
    {
        $this->carrera = $carrera;

        return $this;
    }

    /**
     * Get carrera
     *
     * @return \Sgpg\CarreraBundle\Entity\Carrera
     */
    public function getCarrera()
    {
        return $this->carrera;
    }
}