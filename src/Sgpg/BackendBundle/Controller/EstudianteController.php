<?php

namespace Sgpg\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Sgpg\BackendBundle\Model\EstudianteModel;
use Sgpg\BackendBundle\Form\EstudianteModelType;
use Sgpg\EstudianteBundle\Entity\Estudiante;

class EstudianteController extends Controller
{
    /**
     * @Route("/estudiantes", name="backend_estudiante_portada")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->get('security.context')->getToken()->getUser();

        $estudiantes = $em->getRepository('EstudianteBundle:Estudiante')->findAll();

        return array(   'estudiantes' => $estudiantes,
                        'usuario' => $usuario
                    );
    }

    /**
     * @Route("/estudiantes/nuevo", name="backend_estudiante_nuevo")
     * @Template()
     */
    public function nuevoAction(Request $request)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $mEstudiante = new EstudianteModel();
        $form   = $this->createForm(new EstudianteModelType(), $mEstudiante);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $bestudiante = $em->getRepository('EstudianteBundle:Estudiante')->findOneByCi($mEstudiante->ci);
                if ($bestudiante == null)
                {
                    $estudiante = new Estudiante();
                    $estudiante->setMencion($mEstudiante->mencion);
                    $estudiante->setNombres($mEstudiante->nombres);
                    $estudiante->setApPaterno($mEstudiante->apPaterno);
                    $estudiante->setApMaterno($mEstudiante->apMaterno);
                    $estudiante->setTipo($mEstudiante->tipo);
                    $estudiante->setCi($mEstudiante->ci);
                    $estudiante->setSalt(md5(time()));
                    $encoder = $this->get('security.encoder_factory')->getEncoder($estudiante);
                    $passwordCodificado = $encoder->encodePassword(
                        $estudiante->getCi(),
                        $estudiante->getSalt()
                    );
                    $estudiante->setPassword($passwordCodificado);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($estudiante);
                    $em->flush();
                    $flashBag = $this->get('session')->getFlashBag();
                    $flashBag->add('smtc_success', 'Se ha creado un Estudiante con exito');

                    return $this->redirect($this->generateUrl('backend_estudiante_portada'));
                }
                else
                {
                    $flashBag = $this->get('session')->getFlashBag();
                    $flashBag->add('smtc_warning', 'El Estudiante ya esta Registrado');
                }
            }
        }

        return array(
            'estudiante' => $mEstudiante,
            'form'   => $form->createView(),
            'usuario' => $usuario
        );
    }

    public function verAction($estudiante_id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $estudiante = $em->getRepository('EstudianteBundle:Estudiante')->findOneById($estudiante_id);

        return $this->render('BackendBundle:Estudiante:ver.html.twig', array(
            'estudiante'   => $estudiante,
            'usuario' => $usuario
            ));
    }

    public function editarAction($estudiante_id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->get('security.context')->getToken()->getUser();
        $estudiante = $em->getRepository('EstudianteBundle:Estudiante')->findOneById($estudiante_id);
        $entity = new EstudianteModel();

        $entity->nombres = $estudiante->getNombres();
        $entity->apPaterno = $estudiante->getApPaterno();
        $entity->apMaterno = $estudiante->getApMaterno();
        $entity->ci = $estudiante->getCi();
        $entity->tipo = $estudiante->getTipo();
        $entity->mencion = $estudiante->getMencion();

        $form   = $this->createForm(new EstudianteModelType(), $entity);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $estudiante->setMencion($entity->mencion);
                $estudiante->setNombres($entity->nombres);
                $estudiante->setApPaterno($entity->apPaterno);
                $estudiante->setApMaterno($entity->apMaterno);
                $estudiante->setTipo($entity->tipo);
                $estudiante->setCi($entity->ci);
                $estudiante->setSalt(md5(time()));
                $encoder = $this->get('security.encoder_factory')->getEncoder($estudiante);
                $passwordCodificado = $encoder->encodePassword(
                    $estudiante->getCi(),
                    $estudiante->getSalt()
                );
                $estudiante->setPassword($passwordCodificado);

                $em->persist($estudiante);
                $em->flush();
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha modificado los datos del Estudiante con exito');

                return $this->redirect($this->generateUrl('backend_estudiante_portada'));
            }
        }

        return $this->render('BackendBundle:Estudiante:editar.html.twig', array(
            'estudiante' => $estudiante,
            'form'   => $form->createView(),
            'usuario' => $usuario
        ));
    }

    public function eliminarAction($estudiante_id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EstudianteBundle:Estudiante')->findOneById($estudiante_id);

        if ($entity->getActivo())
        {
            $entity->setActivo(false);

            $em->persist($entity);
            $em->flush();
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha Eliminado al Estudiante: '.$entity.' con exito');

            return $this->redirect($this->generateUrl('backend_estudiante_portada'));
        }
        else
        {
            $entity->setActivo(true);

            $em->persist($entity);
            $em->flush();
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha Activado al Estudiante: '.$entity.' con exito');

            return $this->redirect($this->generateUrl('backend_estudiante_portada'));
        }
    }
}