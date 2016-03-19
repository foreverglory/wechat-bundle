<?php

namespace Glory\Bundle\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Glory\Bundle\WechatBundle\WechatEvents;
use Glory\Bundle\WechatBundle\EventDispatcher\Event;

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
