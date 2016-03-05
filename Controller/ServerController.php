<?php

namespace Glory\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Glory\WechatBundle\Entity\Message;
use Glory\WechatBundle\Events;
use Glory\WechatBundle\Event\ServerEvent;

/**
 * Description of CommController
 *
 * @author ForeverGlory
 */
class ServerController extends Controller
{

    public function messageAction(Request $request, $id)
    {
        $app = $this->get('wechat.app.' . $id);
        $dispatcher = $this->get('event_dispatcher');
        $app->server->setMessageHandler(function($message) use ($app, $dispatcher) {
            $event = new ServerEvent($app, $message);
            $dispatcher->dispatch(Events::SERVER, $event);
            return $event->getResponse();
        });
        return $app->server->serve();
    }

}
