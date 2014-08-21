<?php

namespace Sgpg\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use Sgpg\BackendBundle\Model\MencionModel;
use Sgpg\BackendBundle\Form\MencionModelType;
use Sgpg\CarreraBundle\Entity\Mencion;

class MencionController extends Controller
{
    /**
     * @Route("/menciones", name="backend_mencion_portada")
     * @Template()
     */
    public function indexAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $carreras = $em->getRepository('CarreraBundle:Carrera')->findAll();
        $menciones = $em->getRepository('CarreraBundle:Mencion')->findAll();

        return array(   'menciones' => $menciones,
                        'carreras' => $carreras,
                        'usuario' => $usuario
                    );
    }

    /**
     * @Route("/mencion", name="backend_select_menciones")
     * @Template()
     */
    public function mencionesAction()
    {
        $carrera_id = $this->getRequest()->request->get('carrera_id');

        $em = $this->getDoctrine()->getManager();

        $menciones = $em->getRepository('CarreraBundle:Mencion')->findByCarrera($carrera_id);

        return array(
            'menciones' => $menciones
        );
    }

    /**
     * @Route("/menciones/nuevo", name="backend_mencion_nuevo")
     * @Template()
     */
    public function nuevoAction(Request $request)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $mMencion = new MencionModel();
        $form   = $this->createForm(new MencionModelType(), $mMencion);

        if ($request->isMethod('POST'))
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $mencion = new Mencion();
                $mencion->setCarrera($mMencion->carrera);
                $mencion->setNombre($mMencion->nombre);
                $mencion->setDescripcion($mMencion->descripcion);
                $em = $this->getDoctrine()->getManager();
                $em->persist($mencion);
                $em->flush();
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado una Mencion con exito');

                $carreras = $em->getRepository('CarreraBundle:Carrera')->findAll();
                $menciones = $em->getRepository('CarreraBundle:Mencion')->findAll();

                return $this->redirect($this->generateUrl('backend_mencion_portada'));
            }
            else
            {
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_error', 'Revise los datos son erroneos');
            }
        }

        return array(
            'form'   => $form->createView(),
            'usuario' => $usuario
        );
    }

    public function verAction($mencion_id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $mencion = $em->getRepository('CarreraBundle:Mencion')->findOneById($mencion_id);

        return $this->render('BackendBundle:Mencion:ver.html.twig', array(
            'mencion'   => $mencion,
            'usuario'   => $usuario
            ));
    }

    public function editarAction($mencion_id)
    {
        $request = $this->getRequest();
        $usuario = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $mencion = $em->getRepository('CarreraBundle:Mencion')->findOneById($mencion_id);

        $mmencion = new MencionModel();
        $mmencion->carrera = $mencion->getCarrera();
        $mmencion->nombre = $mencion->getNombre();
        $mmencion->descripcion = $mencion->getDescripcion();

        $form   = $this->createForm(new MencionModelType(), $mmencion);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $bmencion = $em->getRepository('EstudianteBundle:Estudiante')->findOneByCi($mmencion->nombre);
                if ($bmencion == null)
                {
                    $mencion->setCarrera($mmencion->carrera);
                    $mencion->setDescripcion($mmencion->nombre);
                    $mencion->setActivo($mmencion->descripcion);
                    $mencion->setFechaModificacion(new \DateTime());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($mencion);
                    $em->flush();
                    $flashBag = $this->get('session')->getFlashBag();
                    $flashBag->add('smtc_success', 'Se ha editado la Mencion con exito');

                    return $this->redirect($this->generateUrl('backend_mencion_portada'));
                }
                else
                {
                    $flashBag = $this->get('session')->getFlashBag();
                    $flashBag->add('smtc_warning', 'La Mencion ya Existe');
                }
            }
        }

        return $this->render('BackendBundle:Mencion:editar.html.twig', array(
            'form'   => $form->createView(),
            'usuario' => $usuario,
            'mencion' => $mencion
        ));
    }

    public function eliminarAction($mencion_id)
    {
        $em = $this->getDoctrine()->getManager();

        $mencion = $em->getRepository('CarreraBundle:Mencion')->findOneById($mencion_id);

        if ($mencion->getActivo())
        {
            $mencion->setActivo(false);

            $em->persist($mencion);
            $em->flush();
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha Eliminado la Mencion de '.$mencion->getNombre().' con exito');

            return $this->redirect($this->generateUrl('backend_mencion_portada'));
        }
        else
        {
            $mencion->setActivo(true);

            $em->persist($mencion);
            $em->flush();
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha Activado la Mencion de '.$mencion->getNombre().' con exito');

            return $this->redirect($this->generateUrl('backend_mencion_portada'));
        }
    }

}