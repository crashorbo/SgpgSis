<?php

namespace Sgpg\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use Sgpg\BackendBundle\Model\HorarioModel;
use Sgpg\BackendBundle\Form\HorarioModelType;
use Sgpg\ProyectoBundle\Entity\Horario;

class HorarioController extends Controller
{
    /**
     * @Route("/carreras", name="backend_carrera_portada")
     * @Template()
     */
    public function indexAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $horarios = $em->getRepository('ProyectoBundle:Horario')->findAll();

        return array( 'horarios' => $horarios, 'usuario' => $usuario);
    }

    /**
     * @Route("/carreras/nuevo", name="backend_carrera_nuevo")
     * @Template()
     */
    public function nuevoAction(Request $request)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $entity = new HorarioModel();
        $form   = $this->createForm(new HorarioModelType(), $entity);

        if ($request->isMethod('POST'))
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $horario = new Horario();
                $horario->setTipo($entity->tipo);
                $horario->setDia($entity->dia);
                $horario->setHoraInicio($entity->horaini);
                $horario->setHoraFinal($entity->horafin);

                $em = $this->getDoctrine()->getManager();
                $em->persist($horario);
                $em->flush();
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado un Horario con exito');

                return $this->redirect($this->generateUrl('backend_horario_portada'));
            }
        }

        return array(
            'form'   => $form->createView(), 'usuario' => $usuario
        );
    }

    public function verAction($horario_id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $horario = $em->getRepository('ProyectoBundle:Horario')->findOneById($horario_id);

        return $this->render('BackendBundle:Horario:ver.html.twig', array(
            'horario'   => $horario,
            'usuario' => $usuario
            ));
    }

}