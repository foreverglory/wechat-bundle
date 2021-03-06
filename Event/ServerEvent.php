<?php

namespace Glory\Bundle\WechatBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Description of WechatEvent
 *
 * @author ForeverGlory
 */
class ServerEvent extends Event
{

    protected $app;
    protected $request;
    protected $response;

    public function __construct($app, $request)
    {
        $this->app = $app;
        $this->request = $request;
    }

    public function getApp()
    {
        return $this->app;
    }

    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function isResponse()
    {
        return !empty($this->response);
    }

    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

}
