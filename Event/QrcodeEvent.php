<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\WechatBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Description of QrcodeEvent
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class QrcodeEvent extends Event
{

    protected $code;
    protected $isForever;
    protected $expire;

    public function __construct($code, $isForever, $expire = 0)
    {
        $this->code = $code;
        $this->isForever = $isForever;
        $this->expire = $expire;
    }

    public function isForever()
    {
        return $this->isForever;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setExpire($expire)
    {
        if ($this->isForever) {
            throw new \LogicException('forever qrcode, never expire.');
        }
        $this->expire = $expire;
        return $this;
    }

    public function getExpire()
    {
        return $this->expire;
    }

}
