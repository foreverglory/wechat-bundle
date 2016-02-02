<?php

namespace Glory\WechatBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\Event as BaseEvent;
use Overtrue\Wechat\Messages\BaseMessage;

/**
 * Description of Event
 *
 * @author ForeverGlory
 */
class Event extends BaseEvent
{

    protected $app;
    protected $type;
    protected $message;
    protected $return;

    public function setApp($app)
    {
        $this->app = $app;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function setReturn($return)
    {
        if ($return instanceof BaseMessage) {
            $this->return = $return;
            return $this;
        }
        throw new Exception(sprintf('return must extends %s', 'Overtrue\Wechat\Messages\BaseMessage'));
    }

    public function getApp()
    {
        return $this->app;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getReturn()
    {
        return $this->return;
    }

}
