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

class DefensaController extends Controller
{
    public function defensaAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $tribunales = $em->getRepository('ProyectoBundle:Tribunal')->findByTribunal($usuario);

        $fecha = new \DateTime();
        $sfecha = $fecha->format('d-m-Y');

        return $this->render('DocenteBundle:Defensa:defensa.html.twig',
            array(  'usuario'       =>  $usuario,
                    'tribunales'    =>  $tribunales,
                    'fecha'         =>  $sfecha
                ));
    }
}