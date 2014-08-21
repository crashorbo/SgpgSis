<?php

namespace Sgpg\ProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Seguimiento
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Seguimiento
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
     * @ORM\Column(name="tipo", type="string", length=20)
     */
    protected $tipo;

    /**
     * @var text
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="string")
     */
    protected $rutaArchivo;

    /**
     * @var UploadedFile
     */
    protected $archivo;

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

    /**
     * @ORM\ManyToOne(targetEntity = "Sgpg\ProyectoBundle\Entity\Proyecto")
     */
    protected $proyecto;

    /**
     * @ORM\OneToMany(targetEntity = "Sgpg\ProyectoBundle\Entity\Observacion", mappedBy = "seguimiento")
     */
    protected $observaciones;

    /**
     * @ORM\OneToMany(targetEntity = "Sgpg\ProyectoBundle\Entity\DefensaHorario", mappedBy = "seguimiento")
     */
    protected $defensaHorarios;

    public function subirArchivo($directorioDestino)
    {
        if (null === $this->getArchivo()){
            return;
        }

        $nombreArchivo = uniqid('sgpg-').'-1.'.$this->getArchivo()->guessExtension();

        $this->getArchivo()->move($directorioDestino, $nombreArchivo);

        $this->setRutaArchivo($nombreArchivo);
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
     * Set tipo
     *
     * @param string $tipo
     * @return Seguimiento
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

    /**
     * Set descripcion
     *
     * @param text $descripcion
     * @return Seguimiento
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return text
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

     /**
     * Set rutaArchivo
     *
     * @param string $rutaArchivo
     */
    public function setRutaArchivo($rutaArchivo)
    {
        $this->rutaArchivo = $rutaArchivo;
    }

    /**
     * Get rutaArchivo
     *
     * @return string
     */
    public function getRutaArchivo()
    {
        return $this->rutaArchivo;
    }

    /**
     * Set archivo
     *
     * @param UploadedFile $archivo
     * @return Seguimiento
     */
    public function setArchivo(UploadedFile $archivo = null)
    {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Get archivo
     *
     * @return string
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Seguimiento
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
     * @return Seguimiento
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
     * @return Seguimiento
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
     * @return Seguimiento
     */
    public function setProyecto(\Sgpg\ProyectoBundle\Entity\Proyecto $proyecto = null)
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
     * Constructor
     */
    public function __construct()
    {
        $this->observaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setEstado(true);
        $this->setFechaCreacion(new \DateTime());
        $this->setFechaModificacion(new \DateTime());
    }

    /**
 * Add observaciones
 *
 * @param \Sgpg\ProyectoBundle\Entity\Observacion $observaciones
 * @return Seguimiento
 */
    public function addObservacion(\Sgpg\ProyectoBundle\Entity\Observacion $observaciones)
    {
        $this->observaciones[] = $observaciones;

        return $this;
    }

    /**
     * Remove observaciones
     *
     * @param \Sgpg\ProyectoBundle\Entity\Observacion $observaciones
     */
    public function removeObservacion(\Sgpg\ProyectoBundle\Entity\Observacion $observaciones)
    {
        $this->observaciones->removeElement($observaciones);
    }

    /**
     * Get observaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Add defensahorarios
     *
     * @param \Sgpg\ProyectoBundle\Entity\DefensaHorario $defensaHorarios
     * @return Seguimiento
     */
    public function addDefensaHorario(\Sgpg\ProyectoBundle\Entity\DefensaHorario $defensaHorarios)
    {
        $this->defensaHorarios[] = $defensaHorarios;

        return $this;
    }

    /**
     * Remove defensaHorarios
     *
     * @param \Sgpg\ProyectoBundle\Entity\DefensaHorario $defensaHorarios
     */
    public function removeDefensaHorario(\Sgpg\ProyectoBundle\Entity\DefensaHorario $defensaHorarios)
    {
        $this->observaciones->removeElement($defensaHorarios);
    }

    /**
     * Get observaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDefensaHorarios()
    {
        return $this->defensaHorarios;
    }
}