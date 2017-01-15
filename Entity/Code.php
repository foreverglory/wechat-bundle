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

/**
 * Description of Code
 * 
 * @ORM\Entity
 * @ORM\Table("wechat_code")
 * 
 * @author ForeverGlory <foreverglory@qq.com>
 */
class Code
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", unique=true)
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $code;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="integer")
     */
    protected $expire = 0;

    /**
     *
     * @ORM\Column(type="integer")
     */
    protected $created;

    /**
     * @ORM\Column(type="string")
     */
    protected $app;

}
