<?php

namespace Glory\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GloryWechatBundle:Default:index.html.twig', array('name' => $name));
    }
}
