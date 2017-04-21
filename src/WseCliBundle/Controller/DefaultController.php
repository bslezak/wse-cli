<?php

namespace WseCliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WseCliBundle:Default:index.html.twig');
    }
}
