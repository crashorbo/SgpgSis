<?php

namespace Sgpg\DocenteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Docente
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Sgpg\DocenteBundle\Entity\DocenteRepository")
 *
 */
class Docente implements UserInterface
{

    public function eraseCredentials()
    {

    }

    public function getRoles()
    {
        return array('ROLE_DOCENTE');
    }

    public function getUsername()
    {
        return $this->getCi();
    }

    public function __sleep()
    {
        return array('id', 'ci');
    }


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
     * @ORM\Column(name="nombres", type="string", length=100)
     */
    protected $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="ap_paterno", type="string", length=50)
     */
    protected $apPaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="ap_materno", type="string", length=50)
     */
    protected $apMaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="ci", type="string", length=20)
     */
    protected $ci;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=20, nullable = true)
     */
    protected $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=20, nullable = true)
     */
    protected $celular;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable = true)
     */
    protected $email;

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
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    protected $salt;

    /**
     * @ORM\ManyToOne(targetEntity = "Sgpg\CarreraBundle\Entity\Carrera")
     */
    protected $carrera;

    /**
     * @ORM\OneToMany(targetEntity = "Sgpg\ProyectoBundle\Entity\Proyecto", mappedBy = "tutor")
     */
    protected $proyectos;

    public function __toString()
    {
        return $this->getNombres().' '.$this->getApPaterno().' '.$this->getApMaterno();
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }
    /**
     * Constructor
     */

    public function getEstado()
    {
        if ($this->getActivo())
            return "ACTIVADO";

        return "ELIMINADO";
    }

    public function __construct()
    {
        $this->proyectos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombres
     *
     * @param string $nombres
     * @return Docente
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apPaterno
     *
     * @param string $apPaterno
     * @return Docente
     */
    public function setApPaterno($apPaterno)
    {
        $this->apPaterno = $apPaterno;

        return $this;
    }

    /**
     * Get apPaterno
     *
     * @return string
     */
    public function getApPaterno()
    {
        return $this->apPaterno;
    }

    /**
     * Set apMaterno
     *
     * @param string $apMaterno
     * @return Docente
     */
    public function setApMaterno($apMaterno)
    {
        $this->apMaterno = $apMaterno;

        return $this;
    }

    /**
     * Get apMaterno
     *
     * @return string
     */
    public function getApMaterno()
    {
        return $this->apMaterno;
    }

    /**
     * Set ci
     *
     * @param string $ci
     * @return Docente
     */
    public function setCi($ci)
    {
        $this->ci = $ci;

        return $this;
    }

    /**
     * Get ci
     *
     * @return string
     */
    public function getCi()
    {
        return $this->ci;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Docente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Docente
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Docente
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Docente
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
     * @return Docente
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
     * @return Docente
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
     * Set password
     *
     * @param string $password
     * @return Docente
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Docente
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Add proyectos
     *
     * @param \Sgpg\ProyectoBundle\Entity\Proyecto $proyectos
     * @return Docente
     */
    public function addProyecto(\Sgpg\ProyectoBundle\Entity\Proyecto $proyectos)
    {
        $this->proyectos[] = $proyectos;

        return $this;
    }

    /**
     * Remove proyectos
     *
     * @param \Sgpg\ProyectoBundle\Entity\Proyecto $proyectos
     */
    public function removeProyecto(\Sgpg\ProyectoBundle\Entity\Proyecto $proyectos)
    {
        $this->proyectos->removeElement($proyectos);
    }

    /**
     * Get proyectos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProyectos()
    {
        return $this->proyectos;
    }

    /**
     * Set carrera
     *
     * @param \Sgpg\CarreraBundle\Entity\Carrera $carrera
     * @return Docente
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