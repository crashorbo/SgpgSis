<?php

namespace Sgpg\ProyectoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proyecto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Sgpg\ProyectoBundle\Entity\ProyectoRepository")
 */
class Proyecto
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
     * @ORM\Column(name="nombre", type="string", length=255)
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
     * @ORM\Column(name="fecha_limite", type="date")
     */
    protected $fechaLimite;

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
     * @ORM\ManyToOne(targetEntity = "Sgpg\EstudianteBundle\Entity\Estudiante")
     */
    protected $estudiante;

    /**
     * @ORM\ManyToOne(targetEntity = "Sgpg\DocenteBundle\Entity\Docente")
     */
    protected $tutor;

    /**
     * @ORM\ManyToOne(targetEntity = "Sgpg\DocenteBundle\Entity\Especializacion")
     */
    protected $especialidad;

    /**
     * @ORM\OneToMany(targetEntity = "Sgpg\ProyectoBundle\Entity\Seguimiento", mappedBy = "proyecto")
     */
    protected $seguimientos;

    /**
     * @ORM\Column(name="activo", type = "boolean")
     */
    protected $activo;

    /**
     * @ORM\OneToMany(targetEntity = "Sgpg\ProyectoBundle\Entity\DefensaHorario", mappedBy = "proyecto")
     */
    protected $defhors;

    /**
     * @ORM\OneToMany(targetEntity = "Sgpg\ProyectoBundle\Entity\Tribunal", mappedBy = "proyecto")
     */
    protected $tribunales;

    public function __toString()
    {
        return $this->getNombre();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->seguimientos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->defhors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setFechaCreacion(new \DateTime());
        $this->setFechaModificacion(new \DateTime());
        $this->setActivo(true);
        $fecha = new \DateTime();
        $this->setFechaLimite($fecha->add(date_interval_create_from_date_string('1 year')));
    }

    public function getActivo()
    {
        return $this->activo;
    }

    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    public function getEstado()
    {
        if ($this->getActivo())
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
     * @return Proyecto
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
     * @return Proyecto
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
     * Set fechaLimite
     *
     * @param \DateTime $fechaLimite
     * @return Proyecto
     */
    public function setFechaLimite($fechaLimite)
    {
        $this->fechaLimite = $fechaLimite;

        return $this;
    }

    /**
     * Get fechaLimite
     *
     * @return \DateTime
     */
    public function getFechaLimite()
    {
        return $this->fechaLimite;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Proyecto
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
     * @return Proyecto
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
     * Set estudiante
     *
     * @param \Sgpg\EstudianteBundle\Entity\Estudiante $estudiante
     * @return Proyecto
     */
    public function setEstudiante(\Sgpg\EstudianteBundle\Entity\Estudiante $estudiante = null)
    {
        $this->estudiante = $estudiante;

        return $this;
    }

    /**
     * Get estudiante
     *
     * @return \Sgpg\EstudianteBundle\Entity\Estudiante
     */
    public function getEstudiante()
    {
        return $this->estudiante;
    }

    /**
     * Set tutor
     *
     * @param \Sgpg\DocenteBundle\Entity\Docente $tutor
     * @return Proyecto
     */
    public function setTutor(\Sgpg\DocenteBundle\Entity\Docente $tutor = null)
    {
        $this->tutor = $tutor;

        return $this;
    }

    /**
     * Get tutor
     *
     * @return \Sgpg\DocenteBundle\Entity\Docente
     */
    public function getTutor()
    {
        return $this->tutor;
    }

    /**
     * Set especialidad
     *
     * @param \Sgpg\DocenteBundle\Entity\Especializacion $especialidad
     * @return Proyecto
     */
    public function setEspecialidad(\Sgpg\DocenteBundle\Entity\Especializacion $especialidad = null)
    {
        $this->especialidad = $especialidad;

        return $this;
    }

    /**
     * Get especialidad
     *
     * @return \Sgpg\DocenteBundle\Entity\Especializacion
     */
    public function getEspecialidad()
    {
        return $this->especialidad;
    }



    /**
     * Add segumiento
     *
     * @param \Sgpg\ProyectoBundle\Entity\Seguimiento $seguimientos
     * @return Proyecto
     */
    public function addSeguimiento(\Sgpg\ProyectoBundle\Entity\Seguimiento $seguimientos)
    {
        $this->seguimientos[] = $seguimientos;

        return $this;
    }

    /**
     * Remove seguimiento
     *
     * @param \Sgpg\ProyectoBundle\Entity\Seguimiento $seguimientos
     */
    public function removeSeguimiento(\Sgpg\ProyectoBundle\Entity\Seguimiento $seguimientos)
    {
        $this->defensas->removeElement($seguimientos);
    }

    /**
     * Get seguimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSeguimientos()
    {
        return $this->seguimientos;
    }

    /**
 * Add defensahorario
 *
 * @param \Sgpg\ProyectoBundle\Entity\DefensaHorario $defensahorario
 * @return Proyecto
 */
    public function addDefHor(\Sgpg\ProyectoBundle\Entity\DefensaHorario $defensahorario)
    {
        $this->defhors[] = $defensahorario;

        return $this;
    }

    /**
     * Remove defensahorario
     *
     * @param \Sgpg\ProyectoBundle\Entity\DefensaHorario $defensahorario
     */
    public function removeDefHor(\Sgpg\ProyectoBundle\Entity\DefensaHorario $defensahorario)
    {
        $this->defhors->removeElement($defensahorario);
    }

    /**
     * Get defensahorarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDefHors()
    {
        return $this->defhors;
    }

    /**
     * Add tribunal
     *
     * @param \Sgpg\ProyectoBundle\Entity\Tribunal $tribunal
     * @return Proyecto
     */
    public function addTribunal(\Sgpg\ProyectoBundle\Entity\Tribunal $tribunal)
    {
        $this->tribunales[] = $tribunal;

        return $this;
    }

    /**
     * Remove tribunal
     *
     * @param \Sgpg\ProyectoBundle\Entity\Tribunal $tribunal
     */
    public function removeTribunal(\Sgpg\ProyectoBundle\Entity\Tribunal $tribunal)
    {
        $this->tribunales->removeElement($tribunal);
    }

    /**
     * Get tribunales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTribunales()
    {
        return $this->tribunales;
    }
}