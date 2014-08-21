<?php

namespace Sgpg\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $fecha1 = new \DateTime();
        $fecha = new \DateTime();
        $fecha2 = $fecha->add(date_interval_create_from_date_string('1 year'));
        $diferencia = date_diff($fecha1, $fecha2);
        $dias = $diferencia->format('%a dias');
        return $this->render('FrontendBundle:Default:index.html.twig');
    }
}
