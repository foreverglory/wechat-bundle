<?php

namespace Glory\Bundle\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of AuthController
 *
 * @author ForeverGlory
 */
class OAuthController extends Controller
{

    public function redirectAction(Request $request)
    {
        $app = $this->get('glory_wechat.app');
        return $app->oauth->scopes(['snsapi_userinfo'])->redirect();
    }

    public function callbackAction(Request $request)
    {
        $app = $this->get('glory_wechat.app');
        $user = $app->oauth->user();
        //$this->redirect($url);
        return new Response($user->toJson());
    }

}
