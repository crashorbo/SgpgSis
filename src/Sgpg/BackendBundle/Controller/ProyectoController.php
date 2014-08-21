<?php

namespace Sgpg\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use Sgpg\BackendBundle\Model\CarreraModel;
use Sgpg\BackendBundle\Form\CarreraModelType;
use Sgpg\CarreraBundle\Entity\Carrera;

class ProyectoController extends Controller
{
    /**
     * @Route("/carreras", name="backend_carrera_portada")
     * @Template()
     */
    public function indexAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $proyectos = $em->getRepository('ProyectoBundle:Proyecto')->findAll();

        return array( 'proyectos' => $proyectos, 'usuario' => $usuario);
    }

    /**
     * @Route("/carreras/nuevo", name="backend_carrera_nuevo")
     * @Template()
     */
    public function nuevoAction(Request $request)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $mcarrera = new carreraModel();
        $form   = $this->createForm(new CarreraModelType(), $mcarrera);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $carrera = new Carrera();
                $carrera->setNombre($mcarrera->nombre);
                $carrera->setDescripcion($mcarrera->descripcion);
                $em = $this->getDoctrine()->getManager();
                $em->persist($carrera);
                $em->flush();
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado una carrera:');
            }
        }

        return array(
            'form'   => $form->createView(), 'usuario' => $usuario
        );
    }

    public function verAction($proyecto_id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $proyecto = $em->getRepository('ProyectoBundle:Proyecto')->findOneById($proyecto_id);

        $tribunales = $em->getRepository('ProyectoBundle:Tribunal')->findByProyecto($proyecto_id);

        $diferencia = date_diff(new \DateTime(), $proyecto->getFechaLimite());
        $fecharest = $diferencia->format('%a');

        return $this->render('BackendBundle:Proyecto:ver.html.twig', array(
            'usuario'   =>  $usuario,
            'proyecto'  =>  $proyecto,
            'tribunales'=>  $tribunales,
            'fecharest' =>  $fecharest
            ));
    }

}