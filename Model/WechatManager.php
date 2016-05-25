<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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

}
