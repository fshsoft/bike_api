<?php

namespace Bike\Api\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bike_api');

        $rootNode
            ->children()
                ->arrayNode('dao')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('conn_id')->end()
                            ->scalarNode('db_name')->end()
                            ->scalarNode('prefix')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
