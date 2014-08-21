<?php

namespace Sgpg\CarreraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CarreraBundle:Default:index.html.twig', array('name' => $name));
    }
}
