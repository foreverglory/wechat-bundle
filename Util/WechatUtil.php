<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\WechatBundle\Util;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Glory\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;

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

    public function getOpenId()
    {
        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return;
        }
        if ($token instanceof OAuthToken) {
            $accessToken = $token->getRawToken();
            return empty($accessToken['openid']) ? null : $accessToken['openid'];
        }
        return;
    }

}
