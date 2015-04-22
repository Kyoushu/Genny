<?php

namespace Kyoushu\Genny;

use Kyoushu\Genny\Bundle\GennyBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{

    /**
     * Returns an array of bundles to register.
     *
     * @return BundleInterface[] An array of bundle instances.
     *
     * @api
     */
    public function registerBundles()
    {
        return array(
            new GennyBundle()
        );
    }

    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/Resources/config/config.yml');
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return sprintf('%s/../../../app', __DIR__);
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return sprintf('%s/cache', $this->getRootDir());
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        return sprintf('%s/log', $this->getRootDir());
    }


}