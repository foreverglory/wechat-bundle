<?php

namespace Glory\WechatBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GloryWechatExtension extends Extension
{

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        //$wechatServerDefinition = $container->getDefinition('wechat.app');

        foreach ($config['apps'] as $key => $val) {
            $server = new DefinitionDecorator('wechat.app');
            $options = [
                'app_id' => $val['AppId'],
                'secret' => $val['AppSecret'],
                'token' => $val['Token'],
                'aes_key' => $val['EncodingAESKey'],
                'debug' => true,
                'log' => [
                    'level' => $val['log']['level'],
                    'file' => $val['log']['file'],
                ],
                'oauth' => [
                    'scopes' => $val['oauth']['scopes'],
                    'callback' => $val['oauth']['callback']
                ],
                'payment' => $val['payment']
            ];
            $server->setArguments(array($options));
            $container->setDefinition('wechat.app.' . $key, $server);
        }
    }

}
