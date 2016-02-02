<?php

namespace Glory\WechatBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('glory_wechat');

        $rootNode
                ->children()
                    ->arrayNode('server')
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                        ->children()
                            ->scalarNode('appId')->isRequired()->info('wechat appId')->end()
                            ->scalarNode('token')->isRequired()->info('wechat token')->end()
                            ->scalarNode('key')->defaultValue('')->info('wechat key')->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }

}
