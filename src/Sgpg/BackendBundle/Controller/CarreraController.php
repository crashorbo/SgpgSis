<?php

namespace Sgpg\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sgpg\BackendBundle\Model\CarreraModel;
use Sgpg\BackendBundle\Form\CarreraModelType;
use Sgpg\CarreraBundle\Entity\Carrera;

class CarreraController extends Controller
{
    public function indexAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $carreras = $em->getRepository('CarreraBundle:Carrera')->findAll();

        return $this->render('BackendBundle:Carrera:index.html.twig',array(
            'carreras' => $carreras,
            'usuario' => $usuario
        ));
    }

    public function nuevoAction(Request $request)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $mcarrera = new CarreraModel();
        $form   = $this->createForm(new CarreraModelType(), $mcarrera);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $bcarrera = $em->getRepository('CarreraBundle:Carrera')->findOneByNombre($mcarrera->nombre);

                if ($bcarrera == null)
                {
                    $carrera = new Carrera();
                    $carrera->setNombre($mcarrera->nombre);
                    $carrera->setDescripcion($mcarrera->descripcion);

                    $em->persist($carrera);
                    $em->flush();
                    $flashBag = $this->get('session')->getFlashBag();
                    $flashBag->add('smtc_success', 'Se ha creado una Carrera con exito');

                    return $this->redirect($this->generateUrl('backend_carrera_portada'));
                }
                else
                {
                    $flashBag = $this->get('session')->getFlashBag();
                    $flashBag->add('smtc_warning', 'La Carrera ya existe');
                }
            }
        }

        return $this->render('BackendBundle:Carrera:nuevo.html.twig',array(
            'form'   => $form->createView(),
            'usuario' => $usuario
        ));
    }

    public function verAction($carrera_id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $carrera = $em->getRepository('CarreraBundle:Carrera')->findOneById($carrera_id);

        return $this->render('BackendBundle:Carrera:ver.html.twig', array(
            'carrera'   => $carrera,
            'usuario' => $usuario
            ));
    }

    public function editarAction($carrera_id)
    {
        $request = $this->getRequest();
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $carrera = $em->getRepository('CarreraBundle:Carrera')->findOneById($carrera_id);

        $mcarrera = new CarreraModel();
        $mcarrera->nombre = $carrera->getNombre();
        $mcarrera->descripcion = $carrera->getDescripcion();

        $form   = $this->createForm(new CarreraModelType(), $mcarrera);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $carrera->setNombre($mcarrera->nombre);
                $carrera->setDescripcion($mcarrera->descripcion);
                $carrera->setFechaModificacion(new \DateTime());

                $em->persist($carrera);
                $em->flush();
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha editado una Carrera con exito');

                return $this->redirect($this->generateUrl('backend_carrera_portada'));
            }
        }

        return $this->render('BackendBundle:Carrera:editar.html.twig', array(
            'form'   => $form->createView(),
            'usuario' => $usuario,
            'carrera' => $carrera
        ));
    }

    public function eliminarAction($carrera_id)
    {
        $em = $this->getDoctrine()->getManager();

        $carrera = $em->getRepository('CarreraBundle:Carrera')->findOneById($carrera_id);

        if ($carrera->getActivo())
        {
            $carrera->setActivo(false);

            $em->persist($carrera);
            $em->flush();
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha Eliminado la Carrera de '.$carrera->getNombre().' con exito');

            return $this->redirect($this->generateUrl('backend_carrera_portada'));
        }
        else
        {
            $carrera->setActivo(true);

            $em->persist($carrera);
            $em->flush();
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha Activado la Carrera de '.$carrera->getNombre().' con exito');

            return $this->redirect($this->generateUrl('backend_carrera_portada'));
        }
    }
}