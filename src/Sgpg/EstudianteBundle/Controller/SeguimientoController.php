<?php

namespace Sgpg\EstudianteBundle\Controller;


use Sgpg\ProyectoBundle\Entity\DefensaHorario;
use Sgpg\ProyectoBundle\Entity\Horario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sgpg\EstudianteBundle\Model\SeguimientoModel;
use Sgpg\EstudianteBundle\Form\SeguimientoModelType;
use Sgpg\ProyectoBundle\Entity\Seguimiento;

class SeguimientoController extends Controller
{
    public function seguimientoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $this->get('security.context')->getToken()->getUser();
        $proyecto = $em->getRepository('ProyectoBundle:Proyecto')->findProyectoByPostulante($usuario->getId());

        $seguimientos = $em->getRepository('ProyectoBundle:Seguimiento')->findByProyecto($proyecto->getId());

        return $this->render('EstudianteBundle:Seguimiento:seguimiento.html.twig', array(
            'usuario' => $usuario,
            'seguimientos' => $seguimientos,
            ));
    }
    public function nuevoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->get('security.context')->getToken()->getUser();
        $proyecto = $em->getRepository('ProyectoBundle:Proyecto')->findProyectoByPostulante($usuario->getId());

        $entity = new SeguimientoModel();

        $form = $this->createForm(new SeguimientoModelType(), $entity);

        $form->handleRequest($request);

        if($form->isValid())
        {
            $seguimiento = new Seguimiento();
            $seguimiento->setTipo($entity->tipo);
            $seguimiento->setArchivo($entity->archivo);
            $seguimiento->setDescripcion($entity->descripcion);
            $seguimiento->subirArchivo($this->container->getParameter('sgpg.directorio.seguimientos'));
            $seguimiento->setProyecto($proyecto);

            $em->persist($seguimiento);
            $em->flush();

            $defensahorarios = $em->getRepository('ProyectoBundle:DefensaHorario')->findByProyecto($proyecto);
                $this->seleccionar_fecha($proyecto);

            return $this->redirect($this->generateUrl('estudiante_seguimiento'));
        }
        return $this->render('EstudianteBundle:Seguimiento:nuevo.html.twig', array(
            'form'   => $form->createView(),
            'usuario' => $usuario,
        ));
    }

    protected function seleccionar_fecha($proyecto)
    {
        $em = $this->getDoctrine()->getManager();
        $valor = true;
        $fechaHoy =  new \DateTime();
        $fechaDefensa = $fechaHoy->add(new \DateInterval('P15D'));

        while ($valor)
        {
            $fechaDefensaDia = $fechaDefensa->format('D');
            $horarios = $em->getRepository('ProyectoBundle:Horario')->findByDia($fechaDefensaDia);

            if($horarios != null)
            {
                foreach($horarios as $horario)
                {
                    $fechaProb = $em->getRepository('ProyectoBundle:DefensaHorario')->encontrarFecha($fechaDefensa->format('Y-m-d'), $horario->getId());
                    if ($fechaProb == null)
                    {
                        $defensahorario = new DefensaHorario();
                        $defensahorario->setProyecto($proyecto);
                        $defensahorario->setFecha($fechaDefensa);
                        $defensahorario->setHorario($horario);
                        $em->persist($defensahorario);
                        $em->flush();
                        $valor = false;
                        break;
                    }
                }
            }
            $fechaDefensa = $fechaDefensa->add(new \DateInterval('P1D'));
        }

    }

    public function observacionAction($seguimiento_id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->get('security.context')->getToken()->getUser();

        $seguimiento = $em->getRepository('ProyectoBundle:Seguimiento')->findOneById($seguimiento_id);
        return $this->render('EstudianteBundle:Seguimiento:observacion.html.twig  ', array(
            'usuario'       =>  $usuario,
            'seguimiento'   =>  $seguimiento
        ));
    }
 }

