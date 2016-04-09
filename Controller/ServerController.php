<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Glory\Bundle\WechatBundle\Event\ServerEvent;
use Glory\Bundle\WechatBundle\GloryWechatEvents;
use Symfony\Component\HttpFoundation\Response;
use EasyWeChat\Server\BadRequestException;

/**
 * Description of CommController
 *
 * @author ForeverGlory
 */
class ServerController extends Controller
{

    public function messageAction(Request $request, $id)
    {
        $app = $this->get('glory_wechat.app.' . $id);
        $dispatcher = $this->get('event_dispatcher');
        $app->server->setMessageHandler(function($message) use ($app, $dispatcher) {
            $event = new ServerEvent($app, $message);
            $dispatcher->dispatch(GloryWechatEvents::SERVER_REQUEST, $event);
            $dispatcher->dispatch(GloryWechatEvents::SERVER_RESPONSE, $event);
            return $event->getResponse();
        });
        try {
            $response = $app->server->serve();
        } catch (\Exception $ex) {
            if ($ex instanceof BadRequestException) {
                $response = new Response($ex->getMessage());
            }
        }
        return $response;
    }

}
