<?php

namespace Kyoushu\Genny\Bundle;

use Kyoushu\Genny\Bundle\DependencyInjection\Compiler\CommandCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class GennyBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CommandCompilerPass());
        parent::build($container);
    }

}