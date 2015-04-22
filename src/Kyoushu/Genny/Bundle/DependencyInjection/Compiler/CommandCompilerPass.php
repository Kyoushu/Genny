<?php

namespace Kyoushu\Genny\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CommandCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $applicationDefinition = $container->getDefinition('genny.console.application');

        foreach($container->findTaggedServiceIds('genny.console.command') as $id => $commandDefinition){
            $applicationDefinition->addMethodCall('add', array(new Reference($id)));
        }
    }

}