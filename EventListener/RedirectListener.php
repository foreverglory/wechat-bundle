<?php

namespace Glory\Bundle\WechatBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectListener implements EventSubscriberInterface
{

    protected $container;
    protected $httpUtils;

    public function __construct(ContainerInterface $container, HttpUtils $httpUtils)
    {
        $this->container = $container;
        $this->httpUtils = $httpUtils;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('onKernelRequest', 6),
        );
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($this->container->get('glory_wechat.util')->inWechat()) {
            $request = $event->getRequest();
            try {
                $bundle = $this->getKernel()->getBundle('GloryUserBundle');
                if ($this->httpUtils->checkRequestPath($request, 'glory_user_login')) {
                    $url = $this->container->get('router')->generate('glory_user_oauth_redirect', ['service' => 'wechat']);
                    $response = new RedirectResponse($url);
                    $event->setResponse($response);
                }
            } catch (Exception $ex) {
                
            }
        }
    }

    /**
     * @return KernelInterface
     */
    protected function getKernel()
    {
        return $this->container->get('kernel');
    }

}
