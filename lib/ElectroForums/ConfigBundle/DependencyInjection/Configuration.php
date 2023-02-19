<?php


namespace ElectroForums\ConfigBundle\DependencyInjection;


use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{

    function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('electroforums_configuration_tree');

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