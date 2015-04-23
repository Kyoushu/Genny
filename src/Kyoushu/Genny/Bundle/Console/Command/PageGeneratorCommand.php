<?php

namespace Kyoushu\Genny\Bundle\Console\Command;

use Kyoushu\Genny\Bundle\Generator\PageGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PageGeneratorCommand extends GennyCommand
{

    /**
     * @return PageGenerator
     */
    protected function getPageGenerator()
    {
        return $this->getContainer()->get('genny.page_generator');
    }

    protected function configure()
    {
        $this->setName( ($this->namePrefix ? $this->namePrefix . ':' : '') . 'generate-page' );
        $this->setDescription('Generates HTML files');

        $this->addArgument('name', InputArgument::OPTIONAL, 'The name of a specific page', null);
        $this->addOption('preview', null, InputOption::VALUE_NONE, 'Output the HTML for page');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $preview = $input->getOption('preview');

        if($name){
            $pages = array($this->getPageGenerator()->findPage($name));
        }
        else{
            $pages = $this->getPageGenerator()->getPages();
        }

        foreach($pages as $page){
            if($preview){
                $output->write($page->getHtml());
            }
            else{
                $output->writeln(sprintf('Generating page %s', $page->getPath()));
                $page->generate();
            }
        }
    }


}