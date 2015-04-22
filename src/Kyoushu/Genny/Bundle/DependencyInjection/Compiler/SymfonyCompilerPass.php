<?php

namespace Kyoushu\Genny\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SymfonyCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        // If the container already contains a definition for Twig, use it
        if($container->hasDefinition('twig')){
            $pageGeneratorDefinition = $container->getDefinition('genny.page_generator');
            $pageGeneratorDefinition->addMethodCall('setTwig', array(new Reference('twig')));
        }
    }

}