<?php

/*
 * This file is part of the current project.
 * 
 * (c) ForeverGlory <http://foreverglory.me/>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Glory\Bundle\WechatBundle\Payment\Provider;

use Glory\Bundle\PayBundle\Payment\Provider\AbstractProvider;
use Glory\Bundle\PayBundle\Payment\Provider\ProviderInterface;
use Glory\Bundle\PayBundle\Model\PayInterface;
use Glory\DoctrineManager\DoctrineManager as PayManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use EasyWeChat\Payment\Merchant;
use EasyWeChat\Payment\Payment;
use EasyWeChat\Payment\Order;

/**
 * Description of WechatProvider
 *
 * @author ForeverGlory <foreverglory@qq.com>
 */
class WechatProvider extends AbstractProvider implements ProviderInterface
{

    /**
     * @var PayManager 
     */
    protected $payManager;

    public function __construct(PayManager $PayManager)
    {
        $this->payManager = $PayManager;
    }

    public function setOption($option = [])
    {
        return parent::setOption([
                    'app_id' => $option['app'],
                    'merchant_id' => $option['id'],
                    'key' => $option['key'],
                    'notify_url' => $this->getNotifyUrl(),
        ]);
    }

    public function process(PayInterface $pay)
    {
        $element = '<img src="' . $this->generateUrl('glory_wechat_pay_qrcode', ['id' => $pay->getId()]) . '"/>';
        $wechatUtil = $this->container->get('glory_wechat.util');
        if (!$wechatUtil->inWechat()) {
            return $element;
        }
        $payment = $this->getPayment();
        $openid = $wechatUtil->getOpenId();
        if (empty($openid)) {
            return $this->getOAuthResponse();
        }
        $result = $payment->prepare(new Order([
            'body' => $pay->getBody(),
            'detail' => $pay->getDetail(),
            'out_trade_no' => $pay->getSn(),
            'total_fee' => floatval($pay->getAmount()) * 100,
            'trade_type' => 'JSAPI', //公众号内支付
            'openid' => $openid, //公众号支付必须获取用户openid
        ]));
        $json = $payment->configForPayment($result->prepay_id);
        $script = '<script type="text/javascript">
            function wechatPay(){
                if (typeof WeixinJSBridge != "undefined") {
                    WeixinJSBridge.invoke(
                            "getBrandWCPayRequest", ' . $json . ',
                            function (res) {
                                if (res.err_msg == "get_brand_wcpay_request:ok") {
                                    alert("支付成功");
                                } else {
                                    alert("支付失败");
                                }
                            }
                    );
                }
            }
            document.addEventListener("WeixinJSBridgeReady", function () {
                if (typeof WeixinJSBridge != "undefined") {
                    WeixinJSBridge.invoke(
                            "getBrandWCPayRequest", ' . $json . ',
                            function (res) {
                                if (res.err_msg == "get_brand_wcpay_request:ok") {
                                    alert("支付成功");
                                } else {
                                    alert("支付失败");
                                }
                            }
                    );
                }
            }, false);
        </script>';
        return $script . $element;
    }

    public function getPayment()
    {
        $merchant = new Merchant($this->option);
        $payment = new Payment($merchant);
        return $payment;
    }

    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
    }

    public function notify(Request $request)
    {
        $payment = $this->getPayment();
        $response = $payment->handleNotify(function($notify, $successful) {
            $pay = $this->getPayForSN($notify->out_trade_no);
            $pay->setData($notify);
            $this->setPay($pay);
            return $successful;
        });
        return $response;
    }

    public function getName()
    {
        return 'wechat';
    }

    /**
     * @param type $sn
     * @return PayInterface
     */
    protected function getPayForSN($sn)
    {
        return $this->payManager->findOneBy(['sn' => $sn]);
    }

    protected function getOAuthResponse()
    {
        //todo: 后面使用路由而非路径
        $response = new RedirectResponse('/connect/wechat');
        return $response;
    }

}
