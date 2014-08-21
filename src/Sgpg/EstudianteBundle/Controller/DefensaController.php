<?php

namespace Sgpg\EstudianteBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sgpg\EstudianteBundle\Model\ProyectoModel;
use Sgpg\EstudianteBundle\Form\ProyectoModelType;
use Sgpg\ProyectoBundle\Entity\Proyecto;

class DefensaController extends Controller
{
    public function defensaAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $proyecto = $em->getRepository('ProyectoBundle:Proyecto')->findProyectoByPostulante($usuario->getId());

        $defensahorario = $em->getRepository('ProyectoBundle:DefensaHorario')->findByProyecto($proyecto);

        return $this->render('EstudianteBundle:Defensa:defensa.html.twig', array(
            'usuario' => $usuario,
            'defhors' => $defensahorario
            ));
    }
}