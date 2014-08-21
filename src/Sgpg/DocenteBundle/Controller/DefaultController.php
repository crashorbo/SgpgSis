<?php

namespace Sgpg\DocenteBundle\Controller;

use Sgpg\DocenteBundle\Form\DocenteModelType;
use Sgpg\DocenteBundle\Model\DocenteModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\HttpFoundation\Request;
use Sgpg\DocenteBundle\Model\DocenteEspModel;
use Sgpg\DocenteBundle\Form\DocenteEspecialidadType;
use Sgpg\DocenteBundle\Entity\DocenteEspecializacion;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        return $this->render('DocenteBundle:Default:index.html.twig',
            array( 'usuario' => $usuario
                ));
    }

    public function loginAction()
    {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();

        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );

        return $this->render('DocenteBundle:Default:login.html.twig', array(
            'error' => $error
        ));
    }

    public function perfilAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $docesps = $em->getRepository('DocenteBundle:DocenteEspecializacion')->findByDocente($usuario->getId());
        $docenteesp = new DocenteEspModel();

        $form = $this->createForm(new DocenteEspecialidadType(), $docenteesp);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $docespe = new DocenteEspecializacion();
            $docespe->setDocente($usuario);
            $docespe->setEspecializacion($docenteesp->especialidad);
            try{
                $em->persist($docespe);
                $em->flush();
            }
            catch(\Exception $ex){
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_warning', 'Ya se Agrego esa Especialidad');
                return $this->redirect($this->generateUrl('docente_perfil'));
            }
            return $this->redirect($this->generateUrl('docente_perfil'));
        }
        return $this->render('DocenteBundle:Default:perfil.html.twig',
            array(  'usuario'   =>  $usuario,
                    'docesps'    =>  $docesps,
                    'form'      =>  $form->createView()
                ));
    }

    public function listaespAction(Request $request)
    {
        $carrera_id = $request->get('carrera_id');

        $em = $this->getDoctrine()->getManager();

        $especialidades = $em->getRepository('DocenteBundle:Especializacion')->findByCarrera($carrera_id);

        return $this->render('DocenteBundle:Default:listaesp.html.twig',
            array(  'especialidades' => $especialidades
        ));
    }

    public function editarAction()
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $usuario = $this->get('security.context')->getToken()->getUser();

        $docente = $em->getRepository('DocenteBundle:Docente')->findOneById($usuario->getId());

        $entity = new DocenteModel();

        $entity->carrera = $docente->getCarrera();
        $entity->nombres = $docente->getNombres();
        $entity->apPaterno = $docente->getApPaterno();
        $entity->apMaterno = $docente->getApMaterno();
        $entity->ci = $docente->getCi();
        $entity->celular = $docente->getCelular();
        $entity->telefono = $docente->getTelefono();
        $entity->email = $docente->getEmail();

        $form = $this->createForm(new DocenteModelType(), $entity);


        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isValid())
            {
                $docente->setCarrera($entity->carrera);
                $docente->setNombres($entity->nombres);
                $docente->setApPaterno($entity->apPaterno);
                $docente->setApMaterno($entity->apMaterno);
                $docente->setCi($entity->ci);
                $docente->setCelular($entity->celular);
                $docente->setTelefono($entity->telefono);
                $docente->setEmail($entity->email);
                if ($entity->password != "")
                {
                    $docente->setSalt(md5(time()));
                    $encoder = $this->get('security.encoder_factory')->getEncoder($docente);
                    $passwordCodificado = $encoder->encodePassword(
                        $entity->password,
                        $docente->getSalt()
                    );
                    $docente->setPassword($passwordCodificado);
                }
                $em->persist($docente);
                $em->flush();
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha cambiado los datos con exito');

                return $this->redirect($this->generateUrl('docente_editar'));
            }
        }
        return $this->render('DocenteBundle:Default:editar.html.twig', array(
            'docente'   =>  $docente,
            'form'      =>  $form->createView(),
            'usuario'   =>  $usuario
        ));
    }

    public function eliminarAction($esp_id)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $this->get('security.context')->getToken()->getUser();

        $espdocs = $em->getRepository('DocenteBundle:DocenteEspecializacion')->findByDocente($usuario);

        foreach($espdocs as $espdoc )
        {
            if($espdoc->getEspecializacion()->getId() == $esp_id)
            {
                $em->remove($espdoc);
                $em->flush();
                return $this->redirect($this->generateUrl('docente_perfil'));
            }
        }
    }
}
