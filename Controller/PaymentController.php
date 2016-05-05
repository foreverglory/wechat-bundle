<?php

/*
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 */

namespace Glory\Bundle\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EasyWeChat\Payment\Merchant;
use EasyWeChat\Payment\Payment;
use EasyWeChat\Payment\Order;
use Endroid\QrCode\QrCode;

/**
 * Description of PayController
 *
 * @author ForeverGlory
 */
class PaymentController extends Controller
{

    /**
     * 生成支付二维码
     * @return Response
     */
    public function qrcodeAction(Request $request, $id)
    {
        $payManager = $this->get('glory_pay.pay_manager');
        $order = $payManager->getOrder($id);
        $payment = $this->getPayment();
        $result = $payment->prepare(new Order([
            'body' => $order->getBody(),
            'detail' => $order->getDetail(),
            'out_trade_no' => $id,
            'total_fee' => floatval($order->getAmount()) * 100,
            'trade_type' => 'NATIVE', //扫码支付
        ]));
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $url = $result['code_url'];
        } else {
            
        }
        $qrCode = new QrCode();
        $qrCode->setText($url)
                ->setSize(240)
                ->setPadding(20);
        $content = $qrCode->get('png');
        return new Response($content, 200, array('Content-Type' => 'image/png'));
    }

    protected function getPayment()
    {
        $merchant = new Merchant([
            'app_id' => $this->container->getParameter('wechat_id'),
            'merchant_id' => $this->container->getParameter('wechat_partner'),
            'key' => $this->container->getParameter('wechat_partnerkey'),
            'notify_url' => $this->getNotifyUrl(),
        ]);
        $payment = new Payment($merchant);
        return $payment;
    }

    protected function getNotifyUrl()
    {
        return $this->generateUrl('glory_pay_notify', ['service' => 'wechat'], true);
    }

}
