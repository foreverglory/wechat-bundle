<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\WechatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Glory\Bundle\MenuBundle\Entity\Menu as BaseMenu;

/**
 * Description of Menu
 * 
 * @ORM\Entity
 * @ORM\Table("wechat_menu")
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class Menu extends BaseMenu
{
    
}
