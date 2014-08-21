<?php

namespace Sgpg\ProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tribunal
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tribunal
{
    /**
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity = "Sgpg\ProyectoBundle\Entity\Proyecto")
     */
    protected $proyecto;

    /**
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity = "Sgpg\DocenteBundle\Entity\Docente")
     */
    protected $tribunal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="date")
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="date")
     */
    private $fechaModificacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    public function __construct()
    {
        $this->setFechaModificacion(new \DateTime());
        $this->setFechaCreacion(new \DateTime());
        $this->setEstado(true);
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Tribunal
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
     * @return Tribunal
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
     * @return Tribunal
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
     * Set proyecto
     *
     * @param \Sgpg\ProyectoBundle\Entity\Proyecto $proyecto
     * @return Tribunal
     */
    public function setProyecto(\Sgpg\ProyectoBundle\Entity\Proyecto $proyecto)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return \Sgpg\ProyectoBundle\Entity\Proyecto
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }

    /**
     * Set tribunal
     *
     * @param \Sgpg\ProyectoBundle\Entity\Tribunal $tribunal
     * @return Tribunal
     */
    public function setTribunal(\Sgpg\DocenteBundle\Entity\Docente $docente)
    {
        $this->tribunal = $docente;

        return $this;
    }

    /**
     * Get tribunal
     *
     * @return \Sgpg\ProyectoBundle\Entity\Tribunal
     */
    public function getTribunal()
    {
        return $this->tribunal;
    }
}