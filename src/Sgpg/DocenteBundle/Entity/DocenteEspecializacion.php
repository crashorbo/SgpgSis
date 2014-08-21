<?php

namespace Sgpg\DocenteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocenteEspecializacion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Sgpg\DocenteBundle\Entity\DocenteEspRepository")
 */
class DocenteEspecializacion
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity = "Sgpg\DocenteBundle\Entity\Docente")
     */
    protected $docente;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity = "Sgpg\DocenteBundle\Entity\Especializacion")
     */
    protected $especializacion;
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

    public function __construct()
    {
        $this->setFechaCreacion(new \DateTime());
        $this->setFechaModificacion(new \DateTime());
        $this->setEstado(True);
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return DocenteEspecializacion
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
     * @return DocenteEspecializacion
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
     * @return DocenteEspecializacion
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
     * Set docente
     *
     * @param \Sgpg\DocenteBundle\Entity\Docente $docente
     * @return DocenteEspecializacion
     */
    public function setDocente(\Sgpg\DocenteBundle\Entity\Docente $docente)
    {
        $this->docente = $docente;

        return $this;
    }

    /**
     * Get docente
     *
     * @return \Sgpg\DocenteBundle\Entity\Docente
     */
    public function getDocente()
    {
        return $this->docente;
    }

    /**
     * Set especializacion
     *
     * @param \Sgpg\DocenteBundle\Entity\Especializacion $especializacion
     * @return DocenteEspecializacion
     */
    public function setEspecializacion(\Sgpg\DocenteBundle\Entity\Especializacion $especializacion)
    {
        $this->especializacion = $especializacion;

        return $this;
    }

    /**
     * Get especializacion
     *
     * @return \Sgpg\DocenteBundle\Entity\Especializacion
     */
    public function getEspecializacion()
    {
        return $this->especializacion;
    }
}