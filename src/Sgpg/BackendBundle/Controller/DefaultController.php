<?php

namespace Sgpg\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="backend_portada")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $especialidades = $em->getRepository('DocenteBundle:Especializacion')->findAll();
        $proyectos = $em->getRepository('ProyectoBundle:Proyecto')->findAll();
        $cantidadproyectos = count($proyectos);
        $resultados = array();
        if($cantidadproyectos > 0)
        {
            foreach ($especialidades as $esp)
            {
                $esps = $em->getRepository('ProyectoBundle:Proyecto')->findByEspecialidad($esp->getId());
                $porcentaje = (count($esps)*100)/$cantidadproyectos;
                $resultado = array('nombre' => $esp->getNombre(), 'porcentaje' => $porcentaje);
                array_push($resultados, $resultado);
            }
        }
        $usuario = $this->get('security.context')->getToken()->getUser();
        return array(   'usuario'   => $usuario,
                        'resultados'  =>  $resultados);
    }

    public function loginAction()
    {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();

        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );

        return $this->render('BackendBundle:Default:login.html.twig', array(
            'error' => $error
        ));
    }
}
