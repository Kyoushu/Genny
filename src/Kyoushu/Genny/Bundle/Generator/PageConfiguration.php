<?php

namespace Kyoushu\Genny\Bundle\Generator;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class PageConfiguration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('page');

        $rootNode->children()->scalarNode('_title')->defaultNull();
        $rootNode->children()->scalarNode('_description')->defaultNull();
        $rootNode->children()->scalarNode('_template')->isRequired();

        $urlNode = $rootNode->children()->scalarNode('_url')->isRequired();
        $urlNodeValidation = $urlNode->validate();

        $urlNodeValidation->ifTrue(function($value){
            if(!preg_match('/^\//', $value)) return true;
            if(preg_match('/\.\.?\//', $value)) return true;
            return false;
        })->thenInvalid('Page URL must begin with a forward slash and not contain relative paths');

        $rootNode->ignoreExtraKeys();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        return $treeBuilder;
    }

}