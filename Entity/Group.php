<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\WechatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Glory\Bundle\WechatBundle\Model\Group as BaseGroup;

/**
 * Description of Group
 * @author ForeverGlory <foreverglory@qq.com>
 * 
 * @ORM\Table(name="wechat_group")
 * @ORM\Entity
 */
class Group extends BaseGroup
{

    /**
     * @var integer
     * 
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", unique=true)
     */
    protected $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

}
