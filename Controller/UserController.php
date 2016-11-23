<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EasyWeChat\Support\Collection;

/**
 * Description of UserController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class UserController extends Controller
{

    public function indexAction(Request $request)
    {
        $app = $this->get('glory_wechat.app');
        $userService = $app->user;
        //$users = new Collection();
        $ids = [];
        $nextOpenId = null;

        do {
            $list = $userService->lists($nextOpenId);

            $count = $list->get('count');
            if ($count > 0) {
                $ids += $list->get('data.openid');
            }
            $nextOpenId = $list->get('next_openid');
        } while ($count && $nextOpenId);
        $users = $userService->batchGet($ids);
        return $this->render('GloryWechatBundle:User:index.html.twig', ['list' => $users->get('user_info_list')]);
    }

    private function getUsers($refresh = false)
    {
        if ($refresh) {
            
        }
        return $users;
    }

}
