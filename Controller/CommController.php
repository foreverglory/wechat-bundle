<?php

namespace Glory\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Glory\WechatBundle\WechatEvents;
use Glory\WechatBundle\EventDispatcher\Event;

/**
 * Description of CommController
 *
 * @author ForeverGlory
 */
class CommController extends Controller
{

    public function indexAction(Request $request, $app)
    {
        $server = $this->get('wechat.server.' . $app);
        $types = array('image');
        foreach ($types as $type) {
            $server->on('message', $type, function($message) use ($type, $app) {
                $dispatcher = $this->get('event_dispatcher');
                $event = new Event();
                $event
                        ->setApp($app)
                        ->setType($type)
                        ->setMessage($message);
                $dispatcher->dispatch(WechatEvents::MESSAGE, $event);
                $return = $event->getReturn();
                return $return;
            });
        }
        $result = $server->serve();
        return new \Symfony\Component\HttpFoundation\Response($result);
    }

}
