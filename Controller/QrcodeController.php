<?php

namespace Glory\Bundle\WechatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Glory\Bundle\WechatBundle\GloryWechatEvents;
use Symfony\Component\HttpFoundation\Response;
use Endroid\QrCode\QrCode;

/**
 * Description of QrcodeController
 *
 * @author ForeverGlory
 */
class QrcodeController extends Controller
{

    public function foreverAction(Request $request, $code)
    {
        $qrcode = $this->getAppQrcode();
        $result = $qrcode->forever($code);

        return $this->generateQrcode($result->url);
    }

    public function temporaryAction(Request $request, $code)
    {
        $qrcode = $this->getAppQrcode();
        $expire = $this->container->getParameter('glory_wechat.qrcode.expire');
        $result = $qrcode->temporary($code, $expire);

        return $this->generateQrcode($result->url);
    }

    protected function getAppQrcode()
    {
        $app = $this->get('glory_wechat.app');
        return $app->qrcode;
    }

    protected function generateQrcode($url)
    {
        $qrCode = new QrCode();
        $qrCode->setText($url)
                ->setSize(240)
                ->setPadding(20);
        $content = $qrCode->get('png');
        return new Response($content, 200, array('Content-Type' => 'image/png'));
    }

}
