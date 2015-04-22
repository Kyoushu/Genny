<?php

namespace Kyoushu\Genny\Tests;

use Kyoushu\Genny\Kernel as BaseKernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Filesystem\Filesystem;

class Kernel extends BaseKernel
{

    protected $uuid;

    public function __construct($environment, $debug)
    {
        $this->uuid = uniqid();
        parent::__construct($environment, $debug);
    }

    protected function prepareContainer(ContainerBuilder $container)
    {
        $container->setParameter('kernel.uuid', $this->uuid);
        parent::prepareContainer($container);
    }

    public function getName()
    {
        return sprintf('test_%s', $this->uuid);
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return sprintf('%s/cache/%s', $this->getRootDir(), $this->uuid);
    }

    public function getLogDir()
    {
        return sprintf('%s/logs/%s', $this->getRootDir(), $this->uuid);
    }

    public function destroy()
    {
        $fs = new Filesystem();

        if($fs->exists($this->getCacheDir())){
            $fs->remove($this->getCacheDir());
        }

        if($fs->exists($this->getLogDir())){
            $fs->remove($this->getLogDir());
        }

    }

    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/Resources/config/config.yml');
    }

}