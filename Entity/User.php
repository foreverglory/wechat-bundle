<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\WechatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Glory\Bundle\WechatBundle\Model\User as BaseUser;

/**
 * Description of User
 * @author ForeverGlory <foreverglory@qq.com>
 * 
 * @ORM\Table(name="wechat_user")
 * @ORM\Entity
 */
class User extends BaseUser
{

    /**
     * @var string
     *
     * @ORM\Column(name="unionid", type="string", length=255, unique=true, nullable=true)
     * @ORM\Id
     */
    protected $unionid;

    /**
     * @var string
     *
     * @ORM\Column(name="openid", type="string", length=255)
     * @ORM\Id
     */
    protected $openid;

    /**
     * @var integer
     *
     * @ORM\Column(name="subscribe_time", type="integer", nullable=true)
     */
    protected $subscribeTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="unsubscribe_time", type="integer", nullable=true)
     */
    protected $unsubscribeTime = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=255, nullable=true)
     */
    protected $nickname;

    /**
     * @var integer
     *
     * @ORM\Column(name="sex", type="integer", nullable=true)
     */
    protected $sex = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=255, nullable=true)
     */
    protected $language;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    protected $country;

    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=255, nullable=true)
     */
    protected $province;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="headimgurl", type="string", length=255, nullable=true)
     */
    protected $headimgurl;

    /**
     * @var string
     *
     * @ORM\Column(name="remark", type="string", length=255, nullable=true)
     */
    protected $remark;

    /**
     * @var string
     *
     * @ORM\Column(name="groupid", type="string", length=255, nullable=true)
     */
    protected $groupid;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    protected $status = 1;

}
