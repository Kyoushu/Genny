<?php

namespace Kyoushu\Genny\Bundle\Generator;

use Kyoushu\Genny\Bundle\Exception\GennyException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class PageGenerator
{

    const PATH_REGEX_YML = '/\.yml$/';

    const PATH_REGEX_TEMPLATE = '/\.html\.twig$/';

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
     * @var string
     */
    protected $templatesDir;

    /**
     * @var Page[]
     */
    protected $pages;

    /**
     * @param \Twig_Environment $twig
     * @param string $pagesDir
     * @param string $distDir
     * @param string $templatesDir
     */
    public function __construct(\Twig_Environment $twig, $pagesDir, $distDir, $templatesDir)
    {
        $this->twig = $twig;

        $fs = new Filesystem();

        if(!$fs->exists($pagesDir)) $fs->mkdir($pagesDir);
        if(!$fs->exists($distDir)) $fs->mkdir($distDir);
        if(!$fs->exists($templatesDir)) $fs->mkdir($templatesDir);

        $this->pagesDir = realpath($pagesDir);
        $this->distDir = realpath($distDir);
        $this->templatesDir = realpath($templatesDir);

        $this->load();
    }

    /**
     * @return array
     */
    public function getPageYmlPaths()
    {
        $finder =  Finder::create()
            ->in($this->pagesDir)
            ->files()
            ->name(self::PATH_REGEX_YML);

        $paths = array();

        foreach($finder as $file){
            $paths[] = (string)$file;
        }

        return $paths;
    }

    /**
     * @return array
     */
    public function getTemplatePaths()
    {
        $finder =  Finder::create()
            ->in($this->templatesDir)
            ->files()
            ->name(self::PATH_REGEX_TEMPLATE);

        $paths = array();

        foreach($finder as $file){
            $paths[] = (string)$file;
        }

        return $paths;
    }

    /**
     * @param string $path Path to a template or page YML file
     * @return Page[] Pages generated
     * @throws GennyException
     */
    public function generatePagesByResourcePath($path)
    {
        $affectedPages = array();
        if(preg_match(self::PATH_REGEX_YML, $path)){
            $page = $this->findPageByYmlPath($path);
            $page->generate();
            $affectedPages[] = $page;
        }
        elseif(preg_match(self::PATH_REGEX_TEMPLATE, $path)){
            $template = basename($path);
            $pages = $this->findPagesByTemplate($template);
            foreach($pages as $page){
                $page->generate();
                $affectedPages[] = $page;
            }
        }
        return $affectedPages;
    }

    public function load()
    {
        $this->pages = array();
        foreach($this->getPageYmlPaths() as $file){
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
     * @param string $ymlPath
     * @return Page
     * @throws GennyException
     */
    public function findPageByYmlPath($ymlPath)
    {
        foreach($this->pages as $page){
            if($page->getYmlPath() === $ymlPath) return $page;
        }
        throw new GennyException(sprintf('No page with YML data path "%s" exists', $ymlPath));
    }

    /**
     * @param string $template
     * @return Page[]
     */
    public function findPagesByTemplate($template)
    {
        $pages = array();
        foreach($this->pages as $page){
            if($page->getTemplate() === $template){
                $pages[] = $page;
            }
        }
        return $pages;
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

    /**
     * @return string
     */
    public function getTemplatesDir()
    {
        return $this->templatesDir;
    }

    /**
     * @param string $templatesDir
     * @return $this
     */
    public function setTemplatesDir($templatesDir)
    {
        $this->templatesDir = $templatesDir;
        return $this;
    }

}