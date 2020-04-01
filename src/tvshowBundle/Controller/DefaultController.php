<?php

namespace tvshowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('tvshowBundle:Default:index.html.twig');
    }
}
