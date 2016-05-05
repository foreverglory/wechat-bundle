<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\WechatBundle\Util;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Description of WechatUtil
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class WechatUtil
{

    use ContainerAwareTrait;

    public function inWechat($agent = null)
    {
        $agent = $agent ? : $this->container->get('request')->headers->get('user-agent');
        return strpos($agent, 'MicroMessenger') !== false;
    }

}
