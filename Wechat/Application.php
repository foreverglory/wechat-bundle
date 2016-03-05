<?php

namespace Glory\WechatBundle\Wechat;

use EasyWeChat\Foundation\Application as App;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of Application
 *
 * @author ForeverGlory
 */
class Application extends App
{

    public function __construct(ContainerInterface $container, $config)
    {
        $router = $container->get('router');
        if (empty($config['oauth']['callback'])) {
            $config['oauth']['callback'] = $router->generate('glory_wechat_oauth_callback', array('id' => $config['name']), true);
        }
        if (empty($config['payment']['notify_url'])) {
            $config['payment']['notify_url'] = $router->generate('glory_wechat_pay_notify', array('id' => $config['name']), true);
        }
        parent::__construct($config);
    }

}
