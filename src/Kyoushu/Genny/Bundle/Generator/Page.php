<?php

namespace Kyoushu\Genny\Bundle\Generator;

use Kyoushu\Genny\Bundle\Exception\GennyException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class Page
{

    /**
     * @var PageGenerator
     */
    protected $pageGenerator;

    /**
     * @var string
     */
    protected $ymlPath;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param PageGenerator $pageGenerator
     * @param string $ymlPath
     */
    public function __construct(PageGenerator $pageGenerator, $ymlPath)
    {
        $this->pageGenerator = $pageGenerator;
        $this->ymlPath = realpath($ymlPath);
        $this->loadData();
    }

    /**
     * YML filename without .yml extension
     *
     * @return string
     */
    public function getName()
    {
        return preg_replace('/\.yml$/', '', basename($this->ymlPath));
    }

    protected function loadData()
    {
        if(!file_exists($this->ymlPath)){
            throw new GennyException(sprintf('The page config %s could not be found', $this->ymlPath));
        }

        try{
            $ymlParser = new Yaml();
            $originalData = $ymlParser->parse(file_get_contents($this->ymlPath));

            $processor = new Processor();
            $configuration = new PageConfiguration();
            $data = $processor->processConfiguration($configuration, $originalData);

            // Include keys removed by configuration
            $data = array_replace($originalData['page'], $data);

            $this->data = $data;
        }
        catch(\Exception $e){
            throw new GennyException(sprintf(
                'Cannot load page "%s", %s',
                $this->ymlPath,
                lcfirst($e->getMessage())
            ));
        }
    }

    /**
     * @return string
     */
    public function getYmlPath()
    {
        return $this->ymlPath;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return PageGenerator
     */
    public function getPageGenerator()
    {
        return $this->pageGenerator;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->data['_url'];
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->data['_template'];
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->pageGenerator
            ->getTwig()
            ->render($this->getTemplate(), $this->data);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->pageGenerator->getDistDir() . $this->getUrl();
    }

    public function generate()
    {
        $html = $this->getHtml();
        $fs = new Filesystem();
        $fs->dumpFile($this->getPath(), $html);
    }

}