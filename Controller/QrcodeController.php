<?php

namespace Glory\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Glory\WechatBundle\WechatEvents;
use Glory\WechatBundle\EventDispatcher\Event;

/**
 * Description of QrcodeController
 *
 * @author ForeverGlory
 */
class QrcodeController extends Controller
{

    public function indexAction(Request $request, $id)
    {
        $app = $this->get('wechat.app.' . $id);
        $result = $app->qrcode->temporary(56, 6 * 24 * 3600);
        $ticket = $result->ticket;
        $url = $app->qrcode->url($ticket);
        return new \Symfony\Component\HttpFoundation\Response('<img src="' . $url . '"/>');
    }

}
