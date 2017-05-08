<?php
namespace WseCliBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 *
 * DefaultController
 *
 * @author Brian Slezak <brian@theslezaks.com>
 *
 */
class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('WseCliBundle:Default:index.html.twig');
    }
}
