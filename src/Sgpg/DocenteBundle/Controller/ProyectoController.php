<?php

namespace Sgpg\DocenteBundle\Controller;

use Sgpg\DocenteBundle\Form\ObservacionType;
use Sgpg\DocenteBundle\Model\ObservacionModel;
use Sgpg\ProyectoBundle\Entity\Observacion;
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

class ProyectoController extends Controller
{
    public function proyectoAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $tribunales = $em->getRepository('ProyectoBundle:Tribunal')->findByTribunal($usuario->getId());

        return $this->render('DocenteBundle:Proyecto:proyecto.html.twig',
            array(  'usuario' => $usuario,
                    'tribunales' => $tribunales
                ));
    }

    public function verproyAction($proyecto)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $proyecto = $em->getRepository('ProyectoBundle:Proyecto')->findOneById($proyecto);

        $diferencia = date_diff(new \DateTime(), $proyecto->getFechaLimite());
        $fecha_restante = $diferencia->format('%a');

        return $this->render('DocenteBundle:Proyecto:verproy.html.twig', array(
            'usuario' => $usuario,
            'proyecto' => $proyecto,
            'fecharest' => $fecha_restante
            ));
    }

    public  function observacionesAction($seguimiento_id)
    {
        $request = $this->getRequest();
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $entity = new ObservacionModel();

        $form = $this->createForm(new ObservacionType(), $entity);
        $seguimiento = $em->getRepository('ProyectoBundle:Seguimiento')->findOneById($seguimiento_id);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $observacion = new Observacion();
            $observacion->setDescripcion($entity->descripcion);
            $observacion->setSeguimiento($seguimiento);
            $em->persist($observacion);
            $em->flush();
        }
        return $this->render('DocenteBundle:Observaciones:observaciones.html.twig', array(
            'usuario'       =>  $usuario,
            'seguimiento'   =>  $seguimiento,
            'form'   =>  $form->createView()
        ));
    }
}