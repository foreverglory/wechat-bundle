<?php

namespace Glory\Bundle\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Glory\Bundle\WechatBundle\WechatEvents;
use Glory\Bundle\WechatBundle\EventDispatcher\Event;

/**
 * Description of PayController
 *
 * @author ForeverGlory
 */
class PaymentController extends Controller
{

    public function payAction(Request $request, $id)
    {
        
    }

    public function notifyAction(Request $request, $id)
    {
        $app = $this->get('wechat.app.' . $id);
        $dispatcher = $this->get('event_dispatcher');
        $response = $app->payment->handleNotify(function($notify, $successful) use ($app, $dispatcher) {
            //查找本地订单
//            $order = findOrder($notify->transaction_id);
//            if (!$order) {
//                return 'Order not exist'; //告诉微信，我已经处理完了，订单没找到，别再通知我了
//            }
            if ($successful) {
                //支付成功
            } else {
                
            }
            return true;
        });
        return $response;
    }

}
