<?php

namespace Sgpg\ProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DefensaHorario
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Sgpg\ProyectoBundle\Entity\DefensaHorRepository")
 */
class DefensaHorario
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
     *
     * @ORM\ManyToOne(targetEntity = "Sgpg\ProyectoBundle\Entity\Proyecto")
     */
    protected $proyecto;

    /**
     *
     * @ORM\ManyToOne(targetEntity = "Sgpg\ProyectoBundle\Entity\Horario")
     */
    protected $horario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    protected $fecha;
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

    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->setFechaCreacion(new \DateTime());
        $this->setFechaModificacion(new \DateTime());
        $this->setEstado(true);
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fecha
     * @return DefensaHorario
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return DefensaHorario
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
     * @return DefensaHorario
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
     * @return DefensaHorario
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
     * @return DefensaHorario
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
     * Set horario
     *
     * @param \Sgpg\ProyectoBundle\Entity\Horario $horario
     * @return DefensaHorario
     */
    public function setHorario(\Sgpg\ProyectoBundle\Entity\Horario $horario)
    {
        $this->horario = $horario;
    
        return $this;
    }

    /**
     * Get horario
     *
     * @return \Sgpg\ProyectoBundle\Entity\Horario 
     */
    public function getHorario()
    {
        return $this->horario;
    }
}