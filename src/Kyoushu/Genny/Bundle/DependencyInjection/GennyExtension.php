<?php

namespace Kyoushu\Genny\Bundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class GennyExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('genny.dist_dir', $config['dist_dir']);
        $container->setParameter('genny.templates_dir', $config['templates_dir']);
        $container->setParameter('genny.pages_dir', $config['pages_dir']);
        $container->setParameter('genny.console_command_prefix', $config['console_command_prefix']);
    }

}