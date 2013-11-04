<?php

namespace UAM\Bundle\AwsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('uam_aws');

        $rootNode
            ->children()
                ->scalarNode('config_path')->end()
                ->arrayNode('config')
                    ->children()
                        ->scalarNode('key')->end()
                        ->scalarNode('secret')->end()
                        ->scalarNode('region')->end()
                        ->scalarNode('bucket')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
