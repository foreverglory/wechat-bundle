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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of LotteryController
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class LotteryController extends Controller
{

    public function addAction(Request $request)
    {
        
    }

    public function listAction(Request $request)
    {
        
    }

    public function myAction(Request $request)
    {
        $user = $this->getUser();
        //my get Lottery
        $lotteries = [];
        return $this->render('GloryWechatBundle:Lottery:my.html.twig', [
                    'lotteries' => $lotteries
        ]);
    }

    public function myViewAction(Request $request)
    {
        
    }

}
