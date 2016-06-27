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
        $pay = $payManager->findPay($id);
        $payment = $this->getPayment($pay);
        $result = $payment->prepare(new Order([
            'body' => $pay->getBody(),
            'detail' => $pay->getDetail(),
            'out_trade_no' => $pay->getSn(),
            'total_fee' => floatval($pay->getAmount()) * 100,
            'trade_type' => 'NATIVE', //扫码支付
        ]));
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $url = $result['code_url'];
        } else {
            $url = $result['return_msg'];
        }
        $qrCode = new QrCode();
        $qrCode->setText($url)
                ->setSize(240)
                ->setPadding(20);
        $content = $qrCode->get('png');
        return new Response($content, 200, array('Content-Type' => 'image/png'));
    }

    protected function getPayment($pay)
    {
        return $this->get('glory_pay.provider.' . $pay->getProvider())->getPayment();
    }

}
