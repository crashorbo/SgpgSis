<?php

namespace Sgpg\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use Sgpg\BackendBundle\Model\EspecializacionModel;
use Sgpg\BackendBundle\Form\EspecializacionModelType;
use Sgpg\DocenteBundle\Entity\Especializacion;

class EspecializacionController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $carreras = $em->getRepository('CarreraBundle:Carrera')->findAll();
        $especializaciones = $em->getRepository('DocenteBundle:Especializacion')->findAll();

        return array(   'especializaciones' => $especializaciones,
                        'carreras' => $carreras,
                        'usuario' => $usuario
                    );
    }


    /**
     * @Template()
     */
    public function nuevoAction(Request $request)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $mEspecializacion = new EspecializacionModel();
        $form = $this->createForm(new EspecializacionModelType(), $mEspecializacion);
        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $bespecialidad = $em->getRepository('DocenteBundle:Especializacion')->findByNombre($mEspecializacion->nombre);
                if ($bespecialidad == null)
                {
                    $especializacion = new Especializacion();
                    $especializacion->setCarrera($mEspecializacion->carrera);
                    $especializacion->setNombre($mEspecializacion->nombre);
                    $especializacion->setDescripcion($mEspecializacion->descripcion);
                    $em->persist($especializacion);
                    $em->flush();
                    $flashBag = $this->get('session')->getFlashBag();
                    $flashBag->add('smtc_success', 'Se ha creado una Especializacion con exito');

                    return $this->redirect($this->generateUrl('backend_especialidad_portada'));
                }
                else
                {
                    $flashBag = $this->get('session')->getFlashBag();
                    $flashBag->add('smtc_warning', 'La Especialidad ya existe');
                }
            }
        }
        return array(
            'form'   => $form->createView(),
            'usuario' => $usuario
        );
    }

    public function verAction($especialidad_id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $especialidad = $em->getRepository('DocenteBundle:Especializacion')->findOneById($especialidad_id);

        return $this->render('BackendBundle:Especializacion:ver.html.twig', array(
            'especialidad'   => $especialidad,
            'usuario' => $usuario
            ));
    }

    public function editarAction($especialidad_id)
    {
        $request = $this->getRequest();
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $especialidad = $em->getRepository('DocenteBundle:Especializacion')->findOneById($especialidad_id);

        $mespecialidad = new EspecializacionModel();
        $mespecialidad->carrera = $especialidad->getCarrera();
        $mespecialidad->nombre = $especialidad->getNombre();
        $mespecialidad->descripcion = $especialidad->getDescripcion();

        $form   = $this->createForm(new EspecializacionModelType(), $mespecialidad);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $especialidad->setCarrera($mespecialidad->carrera);
                $especialidad->setNombre($mespecialidad->nombre);
                $especialidad->setDescripcion($mespecialidad->descripcion);
                $especialidad->setFechaModificacion(new \DateTime());

                $em->persist($especialidad);
                $em->flush();
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha editado una especialidad con exito');

                return $this->redirect($this->generateUrl('backend_especialidad_portada'));
            }
        }

        return $this->render('BackendBundle:Especializacion:editar.html.twig', array(
            'form'   => $form->createView(),
            'usuario' => $usuario,
            'especialidad' => $especialidad
        ));
    }

    public function eliminarAction($especialidad_id)
    {
        $em = $this->getDoctrine()->getManager();

        $especialidad = $em->getRepository('DocenteBundle:Especializacion')->findOneById($especialidad_id);

        if ($especialidad->getEstado())
        {
            $especialidad->setEstado(false);

            $em->persist($especialidad);
            $em->flush();
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha Eliminado la Especialidad '.$especialidad->getNombre().' con exito');

            return $this->redirect($this->generateUrl('backend_especialidad_portada'));
        }
        else
        {
            $especialidad->setEstado(true);

            $em->persist($especialidad);
            $em->flush();
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha Activado la Especialidad '.$especialidad->getNombre().' con exito');

            return $this->redirect($this->generateUrl('backend_especialidad_portada'));
        }
    }
}