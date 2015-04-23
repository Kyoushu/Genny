<?php

namespace Kyoushu\Genny\Bundle\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class GennyCommand extends Command implements ContainerAwareInterface
{

    /**
     * @param null|string $namePrefix
     */
    public function __construct($namePrefix)
    {
        $this->setNamePrefix($namePrefix);
        parent::__construct($name);
    }

    /**
     * @var null|ContainerInterface
     */
    protected $container = null;

    /**
     * @var null|string
     */
    protected $namePrefix = null;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface|null
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return null|string
     */
    public function getNamePrefix()
    {
        return $this->namePrefix;
    }

    /**
     * @param null|string $namePrefix
     * @return $this
     */
    public function setNamePrefix($namePrefix)
    {
        $this->namePrefix = $namePrefix;
        return $this;
    }

}