<?php

namespace Glory\Bundle\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of JsController
 *
 * @author ForeverGlory
 */
class JsController extends Controller
{

    public function configAction(Request $request)
    {
        $app = $this->get('glory_wechat.app');
        return new JsonResponse($app->js->config($request->get('api'), $this->getParameter('kernel.debug')));
    }

}
