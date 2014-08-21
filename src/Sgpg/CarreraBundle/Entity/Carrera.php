<?php

namespace Sgpg\CarreraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carrera
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Carrera
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
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    protected $activo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date")
     */
    protected $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="date")
     */
    protected $fechaModificacion;

    /**
     * @var \Objects
     *
     * @ORM\OneToMany(targetEntity = "Sgpg\CarreraBundle\Entity\Mencion", mappedBy = "carrera")
     */
    protected $menciones;

    /**
     * @var \Objects
     *
     * @ORM\OneToMany(targetEntity = "Sgpg\DocenteBundle\Entity\Especializacion", mappedBy = "carrera")
     */
    protected $especializaciones;


    public function __toString()
    {
        return $this->getNombre();
    }

    public function getEstado()
    {
        if($this->getActivo() == 1)
            return "ACTIVADO";
        else
            return "ELIMINADO";
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->menciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->especializaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setFechaRegistro(new \DateTime());
        $this->setFechaModificacion(new \DateTime());
        $this->setActivo(true);
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
     * @return Carrera
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
     * @return Carrera
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
     * @return Carrera
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
     * @return Carrera
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
     * @return Carrera
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
     * Add menciones
     *
     * @param \Sgpg\CarreraBundle\Entity\Mencion $menciones
     * @return Carrera
     */
    public function addMencione(\Sgpg\CarreraBundle\Entity\Mencion $menciones)
    {
        $this->menciones[] = $menciones;

        return $this;
    }

    /**
     * Remove menciones
     *
     * @param \Sgpg\CarreraBundle\Entity\Mencion $menciones
     */
    public function removeMencione(\Sgpg\CarreraBundle\Entity\Mencion $menciones)
    {
        $this->menciones->removeElement($menciones);
    }

    /**
     * Get menciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMenciones()
    {
        return $this->menciones;
    }

    /**
     * Add especializaciones
     *
     * @param \Sgpg\DocenteBundle\Entity\Especializacion $especializaciones
     * @return Carrera
     */
    public function addEspecializacione(\Sgpg\DocenteBundle\Entity\Especializacion $especializaciones)
    {
        $this->especializaciones[] = $especializaciones;

        return $this;
    }

    /**
     * Remove especializaciones
     *
     * @param \Sgpg\DocenteBundle\Entity\Especializacion $especializaciones
     */
    public function removeEspecializacione(\Sgpg\DocenteBundle\Entity\Especializacion $especializaciones)
    {
        $this->especializaciones->removeElement($especializaciones);
    }

    /**
     * Get especializaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEspecializaciones()
    {
        return $this->especializaciones;
    }
}