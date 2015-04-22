<?php

namespace Kyoushu\Genny\Bundle;

use Kyoushu\Genny\Bundle\Console\Command\PageGeneratorCommand;
use Kyoushu\Genny\Bundle\Console\Command\WatchCommand;
use Kyoushu\Genny\Bundle\DependencyInjection\Compiler\SymfonyCompilerPass;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GennyBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new SymfonyCompilerPass());
        parent::build($container);
    }

    public function registerCommands(Application $application)
    {

        $pageGeneratorCommand = new PageGeneratorCommand();
        $pageGeneratorCommand->setContainer($this->container);

        $watchCommand = new WatchCommand();
        $watchCommand->setContainer($this->container);

        $application->add($pageGeneratorCommand);
        $application->add($watchCommand);
    }

}