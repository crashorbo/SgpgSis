<?php

namespace Sgpg\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Sgpg\DocenteBundle\Entity\Docente;
use Sgpg\BackendBundle\Form\DocenteModelType;
use Sgpg\BackendBundle\Model\DocenteModel;

class DocenteController extends Controller
{
    /**
     * @Route("/docentes", name="backend_docente_portada")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->get('security.context')->getToken()->getUser();
        $docentes = $em->getRepository('DocenteBundle:Docente')->findAll();

        return array(   'docentes' => $docentes,
                        'usuario' => $usuario
        );
    }

    /**
     * @Route("/docentes/nuevo", name="backend_docente_nuevo")
     * @Template()
     */
    public function nuevoAction(Request $request)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $entity = new DocenteModel();
        $form   = $this->createForm(new DocenteModelType(), $entity);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $bdocente = $em->getRepository('DocenteBundle:Docente')->findOneByCi($entity->ci);
                if ($bdocente == null)
                {
                    $docente = new Docente();
                    $docente->setCarrera($entity->carrera);
                    $docente->setNombres($entity->nombres);
                    $docente->setApPaterno($entity->apPaterno);
                    $docente->setApMaterno($entity->apMaterno);
                    $docente->setCi($entity->ci);
                    $docente->setSalt(md5(time()));
                    $encoder = $this->get('security.encoder_factory')->getEncoder($docente);
                    $passwordCodificado = $encoder->encodePassword(
                        $docente->getCi(),
                        $docente->getSalt()
                    );
                    $docente->setPassword($passwordCodificado);

                    $em->persist($docente);
                    $em->flush();
                    $flashBag = $this->get('session')->getFlashBag();
                    $flashBag->add('smtc_success', 'Se ha creado un Docente con exito');

                    return $this->redirect($this->generateUrl('backend_docente_portada'));
                }
                else
                {
                    $flashBag = $this->get('session')->getFlashBag();
                    $flashBag->add('smtc_warning', 'El Docente ya esta Registrado');
                }
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'usuario' => $usuario
        );
    }

    public function verAction($docente_id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $docente = $em->getRepository('DocenteBundle:Docente')->findOneById($docente_id);

        return $this->render('BackendBundle:Docente:ver.html.twig', array(
            'docente'   => $docente,
            'usuario' => $usuario
            ));
    }

    public function editarAction($docente_id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $docente = $em->getRepository('DocenteBundle:Docente')->findOneById($docente_id);
        $entity = new DocenteModel();

        $entity->carrera = $docente->getCarrera();
        $entity->nombres = $docente->getNombres();
        $entity->apPaterno = $docente->getApPaterno();
        $entity->apMaterno = $docente->getApMaterno();
        $entity->ci = $docente->getCi();

        $form = $this->createForm(new DocenteModelType(), $entity);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $docente->setCarrera($entity->carrera);
                $docente->setNombres($entity->nombres);
                $docente->setApPaterno($entity->apPaterno);
                $docente->setApMaterno($entity->apMaterno);
                $docente->setCi($entity->ci);
                $docente->setSalt(md5(time()));
                $encoder = $this->get('security.encoder_factory')->getEncoder($docente);
                $passwordCodificado = $encoder->encodePassword(
                    $docente->getCi(),
                    $docente->getSalt()
                );
                $docente->setPassword($passwordCodificado);

                $em->persist($docente);
                $em->flush();
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se han editado los datos del Docente con exito');

                return $this->redirect($this->generateUrl('backend_docente_portada'));
            }
        }

        return $this->render('BackendBundle:Docente:editar.html.twig',array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'usuario' => $usuario,
            'docente' => $docente
        ));
    }

    public function eliminarAction($docente_id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DocenteBundle:Docente')->findOneById($docente_id);

        if ($entity->getActivo())
        {
            $entity->setActivo(false);

            $em->persist($entity);
            $em->flush();
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha Eliminado al Docente: '.$entity.' con exito');

            return $this->redirect($this->generateUrl('backend_docente_portada'));
        }
        else
        {
            $entity->setActivo(true);

            $em->persist($entity);
            $em->flush();
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha Activado al Docente '.$entity.' con exito');

            return $this->redirect($this->generateUrl('backend_docente_portada'));
        }
    }
}