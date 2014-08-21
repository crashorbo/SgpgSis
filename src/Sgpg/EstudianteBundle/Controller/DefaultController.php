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

class DefaultController extends Controller
{
    public function indexAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        return $this->render('EstudianteBundle:Default:index.html.twig',
            array('usuario' => $usuario
                ));
    }

    /**
     * @Route("/", name="estudiante_portada")
     * @Template()
    */
    public function loginAction()
    {
       $peticion = $this->getRequest();
        $sesion = $peticion->getSession();

        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );

        return $this->render('EstudianteBundle:Default:login.html.twig', array(
            'error' => $error
            ));
    }

    public function perfilAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $this->get('security.context')->getToken()->getUser();

        return $this->render('EstudianteBundle:Default:perfil.html.twig', array(
            'usuario'=> $usuario
            ));
    }
}
