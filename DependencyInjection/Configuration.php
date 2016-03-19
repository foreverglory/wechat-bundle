<?php

namespace Glory\Bundle\WechatBundle\DependencyInjection;

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
                    ->arrayNode('apps')
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                        ->beforeNormalization()
                            ->ifTrue(function($v) {
                                return !isset($v['log']);
                            })
                            ->then(function($v) {
                                $v['log'] = array();
                                return $v;
                            })
                        ->end()
                        ->children()
                            ->booleanNode('debug')->defaultFalse()->end()
                            ->scalarNode('app_id')->isRequired()->info('wechat AppId')->end()
                            ->scalarNode('secret')->isRequired()->info('wechat AppSecret')->end()
                            ->scalarNode('token')->isRequired()->info('wechat Token')->end()
                            ->scalarNode('aes_key')->defaultValue('')->info('wechat EncodingAESKey')->end()
                            ->arrayNode('log')
                                ->children()
                                    ->scalarNode('level')->defaultValue('warning')->end()
                                    ->scalarNode('file')->defaultValue('%kernel.logs_dir%/wechat.log')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->beforeNormalization()
                            ->ifTrue(function($v) {
                                return !isset($v['oauth']);
                            })
                            ->then(function($v) {
                                $v['oauth'] = array();
                                return $v;
                            })
                        ->end()
                        ->children()
                            ->arrayNode('oauth')
                                ->children()
                                    ->arrayNode('scopes')
                                        ->beforeNormalization()
                                            ->ifTrue(function ($v) { return empty($v); })
                                            ->then(function ($v) {  return array('snsapi_base'); })
                                        ->end()
                                        ->beforeNormalization()
                                            ->ifTrue(function ($v) { return !is_array($v); })
                                            ->then(function ($v) { return array($v); })
                                        ->end()
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                                ->children()
                                    ->scalarNode('callback')->defaultValue('')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->beforeNormalization()
                            ->ifTrue(function($v) {
                                return !isset($v['payment']);
                            })
                            ->then(function($v) {
                                $v['payment'] = array();
                                return $v;
                            })
                        ->end()
                        ->children()
                            ->arrayNode('payment')
                                ->children()
                                    ->scalarNode('merchant_id')->defaultValue('')->end()
                                    ->scalarNode('key')->defaultValue('')->end()
                                    ->scalarNode('cert_path')->defaultValue('')->end()
                                    ->scalarNode('key_path')->defaultValue('')->end()
                                    ->scalarNode('device_info')->defaultValue('')->end()
                                    ->scalarNode('sub_app_id')->defaultValue('')->end()
                                    ->scalarNode('sub_merchant_id')->defaultValue('')->end()
                                    ->scalarNode('notify_url')->defaultValue('')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }

}
