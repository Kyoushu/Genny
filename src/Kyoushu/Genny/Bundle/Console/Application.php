<?php

namespace Kyoushu\Genny\Bundle\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Application extends BaseApplication implements ContainerAwareInterface
{

    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }



}