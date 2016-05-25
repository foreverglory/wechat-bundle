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
use Glory\Bundle\PayBundle\Model\OrderInterface;
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

    public function process(OrderInterface $order)
    {
        $element = '<img src="' . $this->generateUrl('glory_wechat_pay_qrcode', ['id' => $order->getId()]) . '"/>';
        if (!$this->get('glory_wechat.util')->inWechat()) {
            return $element;
        }
        $payment = $this->getPayment();
        $openid = $this->getOpenId();
        if (empty($openid)) {
            return $this->getOAuthResponse();
        }
        $result = $payment->prepare(new Order([
            'body' => $order->getBody(),
            'detail' => $order->getDetail(),
            'out_trade_no' => $order->getSn(),
            'total_fee' => floatval($order->getAmount()) * 100,
            'trade_type' => 'JSAPI', //公众号内支付
            'openid' => $openid, //公众号支付必须获取用户openid
        ]));
        $json = $payment->configForPayment($result->prepay_id);
        $script = '<script>
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

    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->container->get('router')->generate($route, $parameters, $referenceType);
    }

    /**
     * 
     * @return OrderInterface
     */
    public function getOrder()
    {
        
    }

    public function notify(OrderInterface $order)
    {
        
    }

    public function notifyCheck(Request $request)
    {
        
    }

    public function getName()
    {
        return 'wechat';
    }

    protected function getOpenId()
    {
        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return;
        }
        if ($token instanceof \HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken) {
            $accessToken = $token->getRawToken();
            return empty($accessToken['open_id'])? : $accessToken['open_id'];
        }
        return;
    }

    protected function getOAuthResponse()
    {
        //todo: 后面使用路由而非路径
        $response = new RedirectResponse('/connect/wechat');
        return $response;
    }

}
