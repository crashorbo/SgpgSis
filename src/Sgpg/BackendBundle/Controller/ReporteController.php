<?php

namespace Sgpg\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ps\PdfBundle\Annotation\Pdf;

class ReporteController extends Controller
{
    public function indexAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();

        return $this->render('BackendBundle:Reporte:index.html.twig',array(
            'usuario' => $usuario
        ));
    }

    /**
     * @Pdf()
     */
    public function listproyAction()
    {
        $format = $this->get('request')->get('_format');

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ProyectoBundle:Proyecto')->findAll();

        return $this->render(sprintf('BackendBundle:Reporte:listproy.%s.twig', $format),array(
            'entities'     =>  $entities,
        ));
    }

    /**
     * @Pdf()
     */
    public function listespAction()
    {
        $format = $this->get('request')->get('_format');

        $em = $this->getDoctrine()->getManager();

        $proyectos = $em->getRepository('ProyectoBundle:Proyecto')->findAll();
        $especialidades = $em->getRepository('DocenteBundle:Especializacion')->findAll();

        return $this->render(sprintf('BackendBundle:Reporte:listesp.%s.twig', $format),array(
            'proyectos'         =>  $proyectos,
            'especialidades'    =>  $especialidades
        ));
    }

}