<?php

namespace Sgpg\DocenteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\HttpFoundation\Request;
use Sgpg\DocenteBundle\Model\DocenteEspModel;
use Sgpg\DocenteBundle\Form\DocenteEspecialidadType;
use Sgpg\DocenteBundle\Entity\DocenteEspecializacion;

class TutoriaController extends Controller
{
    public function tutoriaAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $proyectos = $em->getRepository('ProyectoBundle:Proyecto')->findByTutor($usuario->getId());

        return $this->render('DocenteBundle:Tutoria:tutoria.html.twig',
            array( 'usuario' => $usuario,
                    'proyectos' => $proyectos
                ));
    }

    public function verAction($proyecto_id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $proyecto = $em->getRepository('ProyectoBundle:Proyecto')->findOneById($proyecto_id);

        $diferencia = date_diff(new \DateTime(), $proyecto->getFechaLimite());
        $fecha_restante = $diferencia->format('%a');

        return $this->render('DocenteBundle:Tutoria:ver.html.twig', array(
            'usuario' => $usuario,
            'proyecto' => $proyecto,
            'fecharest' => $fecha_restante
        ));
    }

    public  function observacionesAction($seguimiento_id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $seguimiento = $em->getRepository('ProyectoBundle:Seguimiento')->findOneById($seguimiento_id);

        return $this->render('DocenteBundle:Tutoria:observaciones.html.twig', array(
            'usuario'       =>  $usuario,
            'seguimiento'   =>  $seguimiento
        ));
    }
}