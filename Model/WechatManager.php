<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\WechatBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of WechatManager
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class WechatManager
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function inWechat($agent = null)
    {
        $agent = $agent ? : $this->container->get('request')->headers->get('user-agent');
        return strpos($agent, 'MicroMessenger') !== false;
    }

}
