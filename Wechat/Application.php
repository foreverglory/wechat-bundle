<?php

namespace Glory\Bundle\WechatBundle\Wechat;

use EasyWeChat\Foundation\Application as App;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of Application
 *
 * @author ForeverGlory
 */
class Application extends App
{

    public function __construct(ContainerInterface $container, $config = [])
    {
        $router = $container->get('router');
        parent::__construct($config);
    }

}
