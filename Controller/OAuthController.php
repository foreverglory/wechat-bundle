<?php

namespace Glory\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AuthController
 *
 * @author ForeverGlory
 */
class OAuthController extends Controller
{

    public function redirectAction(Request $request, $id)
    {
        $app = $this->get('wechat.app.' . $id);
        return $app->oauth->scopes(['snsapi_userinfo'])->redirect();
    }

    public function callbackAction(Request $request, $id)
    {
        $app = $this->get('wechat.app.' . $id);
        $user = $app->oauth->user();
        //$this->redirect($url);
        return new \Symfony\Component\HttpFoundation\Response($user->toJson());
    }

}
