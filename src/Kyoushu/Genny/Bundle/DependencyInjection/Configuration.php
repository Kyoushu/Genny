<?php

namespace Kyoushu\Genny\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('genny');

        $rootNode->children()->scalarNode('dist_dir')->isRequired();
        $rootNode->children()->scalarNode('templates_dir')->isRequired();
        $rootNode->children()->scalarNode('pages_dir')->isRequired();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        return $treeBuilder;
    }
    
}