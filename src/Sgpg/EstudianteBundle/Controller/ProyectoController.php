<?php

namespace Sgpg\EstudianteBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sgpg\EstudianteBundle\Model\ProyectoModel;
use Sgpg\EstudianteBundle\Form\ProyectoModelType;
use Sgpg\ProyectoBundle\Entity\Proyecto;
use Sgpg\ProyectoBundle\Entity\Tribunal;

class ProyectoController extends Controller
{
    public function proyectoAction()
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $proyecto = $em->getRepository('ProyectoBundle:Proyecto')->findProyectoByPostulante($usuario->getId());
        $tribunales = null;
        $fecha_restante = '';
        if ($proyecto != null)
        {
            $tribunales = $em->getRepository('ProyectoBundle:Tribunal')->findByProyecto($proyecto->getId());
            $diferencia = date_diff(new \DateTime(), $proyecto->getFechaLimite());
            $fecha_restante = $diferencia->format('%a');
        }

        return $this->render('EstudianteBundle:Proyecto:proyecto.html.twig', array(
            'usuario' => $usuario,
            'proyecto' => $proyecto,
            'tribunales' => $tribunales,
            'fecharest' => $fecha_restante
            ));
    }

    public function nuevoproyAction(Request $request)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $entity = new ProyectoModel();
        $form = $this->createForm(new ProyectoModelType(), $entity);
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if($form->isValid())
        {

            $proyecto = new Proyecto();
            $tutor = $em->getRepository('DocenteBundle:Docente')->findRandomDocente();
            $proyecto->setEstudiante($usuario);
            $proyecto->setNombre($entity->nombre);
            $proyecto->setDescripcion($entity->descripcion);
            $proyecto->setEspecialidad($entity->especialidad);
            if ($tutor === null)
                $proyecto->setTutor(null);
            else
                $proyecto->setTutor($tutor);
            $em->persist($proyecto);
            $em->flush();
            $iterador = 0;
            $docenteEsp = $em->getRepository('DocenteBundle:DocenteEspecializacion')->findByEspecializacion($proyecto->getEspecialidad()->getId());

            $tutores = $this->shuffle_assoc($docenteEsp);

            foreach($tutores as $tutorgen)
            {
                if ($tutor->getId() != $tutorgen->getDocente()->getId())
                {
                    $tribunal = new Tribunal();
                    $tribunal->setTribunal($tutorgen->getDocente());
                    $tribunal->setProyecto($proyecto);
                    $em->persist($tribunal);
                    $em->flush();
                    $iterador = $iterador+1;
                }
                if ($iterador > 2)
                {
                    break;
                }
            }

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('smtc_success', 'Se ha creado su proyecto con exito');
            return $this->redirect($this->generateUrl('estudiante_proyecto'));
        }
        return $this->render('EstudianteBundle:Proyecto:nuevoproy.html.twig', array(
            'modelProyecto' => $entity,
            'form'   => $form->createView(),
            'usuario' => $usuario,
        ));
    }

    private function shuffle_assoc($list) {
        if (!is_array($list)) return $list;

        $keys = array_keys($list);
        shuffle($keys);
        $random = array();
        foreach ($keys as $key) {
            $random[$key] = $list[$key];
        }
        return $random;
    }
}


