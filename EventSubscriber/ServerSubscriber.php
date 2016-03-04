<?php

namespace Glory\WechatBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Glory\WechatBundle\Event\WechatEvent;
use Glory\WechatBundle\Events;

class ServerSubscriber implements EventSubscriberInterface
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::SERVER => array(
                array('requestException', 1000),
                array('responseException', -1000),
            )
        );
    }

    public function requestException(WechatEvent $event)
    {
        //todo save $event->getRequest();
        $message = $event->getRequest();
        switch ($message->MsgType) {
            case 'event':
                switch ($message->Event) {
                    case 'subscribe':
                        //扫码关注，带 $message->Ticket, $message->EventKey
                        break;
                    case 'unsubscribe':
                        break;
                    case 'SCAN':
                        //扫码，未关注用户扫码，进入 subscribe 事件，带参数
                        //$message->EventKey 对应生成二维码的值
                        //$message->Ticket
                        break;
                    case 'CLICK':
                        //菜单点击 $message->EventKey 对应菜单设置的值
                        break;
                    case 'VIEW':
                        //菜单链接 $message->EventKey 对应菜单链接
                        break;
                    case 'LOCATION':
                        //上传地址
                        break;
                }
                break;
            case 'text':
                //$message->Content
                break;
            case 'image':
                //$message->MediaId, $message->PicUrl
                break;
            case 'voice':
                //$message->MediaId, $message->Format
                break;
            case 'video':
            case 'shortvideo':
                //$message->MediaId, $message->ThumbMediaId
                break;
            case 'location':
                //$message->Location_X, $message->Location_Y, $message->Scale, $message->Label
                break;
            case 'link':
                //$message->Title, $message->Description, $message->Url
                break;
            case 'business card':
                //todo: 官方没有该接口
                break;
            default:
        }
    }

    public function responseException(WechatEvent $event)
    {
        if (!$event->isResponse()) {
            //$response = $event->getRequest()->toJson();
            //$event->setResponse($response);
        }
    }

}
