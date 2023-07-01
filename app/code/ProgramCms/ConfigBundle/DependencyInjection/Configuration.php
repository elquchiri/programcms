<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Class Configuration
 * @package ProgramCms\ConfigBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('programcms_configuration_tree');

        $rootNode = $builder->getRootNode();
        $rootNode->children()
            ->arrayNode('system_config')
            ->children()
                ->arrayNode('tab')
                    ->children()
                        ->scalarNode('id')->end()
                        ->scalarNode('label')->end()
                    ->end()
                ->end()
                ->arrayNode('sections')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('label')->end()
                            ->scalarNode('tab')->end()
                            ->arrayNode('groups')
                            ->useAttributeAsKey('name')
                            ->arrayPrototype()
                                ->children()
                                    ->scalarNode('label')->end()
                                    ->arrayNode('fields')
                                        ->useAttributeAsKey('name')
                                        ->arrayPrototype()
                                            ->children()
                                                ->scalarNode('type')->end()
                                                ->scalarNode('label')->end()
                                                ->scalarNode('source')->end()
                                                ->scalarNode('defaultValue')->end()
                                            ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $builder;
    }
}