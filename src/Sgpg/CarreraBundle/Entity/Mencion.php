<?php

namespace Sgpg\CarreraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mencion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Mencion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date")
     */
    private $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="date")
     */
    private $fechaModificacion;

    /**
     * @var \Object
     *
     * @ORM\ManyToOne(targetEntity = "Sgpg\CarreraBundle\Entity\Carrera")
     */
    private $carrera;

    /**
     * @var \Object
     *
     * @ORM\OneToMany(targetEntity = "Sgpg\EstudianteBundle\Entity\Estudiante", mappedBy = "mencion")
     */
    private $estudiantes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estudiantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setFechaRegistro(new \DateTime());
        $this->setFechaModificacion(new \DateTime());
        $this->setActivo(true);
    }

    public function getEstado()
    {
        if($this->getActivo() == 1)
            return "ACTIVADO";
        else
            return "ELIMINADO";
    }

    public function __toString()
    {
        return $this->getNombre();
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
     * @return Mencion
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
     * @return Mencion
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
     * Set activo
     *
     * @param boolean $activo
     * @return Mencion
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return Mencion
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Mencion
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
     * Set carrera
     *
     * @param \Sgpg\CarreraBundle\Entity\Carrera $carrera
     * @return Mencion
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

    /**
     * Add estudiantes
     *
     * @param \Sgpg\EstudianteBundle\Entity\Estudiante $estudiantes
     * @return Mencion
     */
    public function addEstudiante(\Sgpg\EstudianteBundle\Entity\Estudiante $estudiantes)
    {
        $this->estudiantes[] = $estudiantes;

        return $this;
    }

    /**
     * Remove estudiantes
     *
     * @param \Sgpg\EstudianteBundle\Entity\Estudiante $estudiantes
     */
    public function removeEstudiante(\Sgpg\EstudianteBundle\Entity\Estudiante $estudiantes)
    {
        $this->estudiantes->removeElement($estudiantes);
    }

    /**
     * Get estudiantes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstudiantes()
    {
        return $this->estudiantes;
    }
}