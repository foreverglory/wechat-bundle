<?php

namespace Glory\Bundle\WechatBundle\DependencyInjection;

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

//        $container->getDefinition('glory_wechat.app')->addArgument($config['app']);
//
//        foreach ($config['apps'] as $key => $val) {
//            $server = new DefinitionDecorator('glory_wechat.app');
//            $options = array_merge($val, array('name' => $key));
//            $server->addArgument($options);
//            $container->setDefinition(sprintf('glory_wechat.app.%s', $key), $server);
//        }
    }

}
