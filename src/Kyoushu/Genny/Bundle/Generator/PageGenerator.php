<?php

namespace Kyoushu\Genny\Bundle\Generator;

use Kyoushu\Genny\Bundle\Exception\GennyException;
use Symfony\Component\Finder\Finder;

class PageGenerator
{

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var string|null
     */
    protected $distDir;

    /**
     * @var string
     */
    protected $pagesDir;

    /**
     * @var Page[]
     */
    protected $pages;

    /**
     * @param \Twig_Environment $twig
     * @param string $pagesDir
     * @param string $distDir
     */
    public function __construct(\Twig_Environment $twig, $pagesDir, $distDir)
    {
        $this->twig = $twig;
        $this->pagesDir = $pagesDir;
        $this->distDir = $distDir;
        $this->loadPages();
    }

    protected function loadPages()
    {
        $this->pages = array();

        $finder = Finder::create()
            ->files()
            ->in($this->pagesDir)
            ->name('/\.yml$/');

        foreach($finder as $file){
            $ymlPath = (string)$file;
            $this->pages[] = new Page($this, $ymlPath);
        }
    }

    /**
     * @return Page[]
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param string $name
     * @return Page
     * @throws GennyException
     */
    public function findPage($name)
    {
        foreach($this->pages as $page){
            if($page->getName() === $name) return $page;
        }
        throw new GennyException(sprintf('The page %s does not exist', $name));
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * @return string
     */
    public function getPagesDir()
    {
        return $this->pagesDir;
    }

    /**
     * @param string $pagesDir
     * @return $this
     */
    public function setPagesDir($pagesDir)
    {
        $this->pagesDir = $pagesDir;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDistDir()
    {
        return $this->distDir;
    }

    /**
     * @param null|string $distDir
     * @return $this
     */
    public function setDistDir($distDir)
    {
        $this->distDir = $distDir;
        return $this;
    }

}