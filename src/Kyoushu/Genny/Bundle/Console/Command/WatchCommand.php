<?php

namespace Kyoushu\Genny\Bundle\Console\Command;

use Illuminate\Filesystem\Filesystem;
use JasonLewis\ResourceWatcher\Tracker;
use JasonLewis\ResourceWatcher\Watcher;
use Kyoushu\Genny\Bundle\Generator\PageGenerator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WatchCommand extends GennyCommand
{

    protected function configure()
    {
        $this->setName( ($this->namePrefix ? $this->namePrefix . ':' : '') . 'watch' );
        $this->setDescription('Generates HTML files when pages or templates are altered');
    }

    /**
     * @return PageGenerator
     */
    protected function getPageGenerator()
    {
        return $this->getContainer()->get('genny.page_generator');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Watching templates and pages for changes</info>');

        $files = new Filesystem();
        $tracker = new Tracker();
        $watcher = new Watcher($tracker, $files);

        $generator = $this->getPageGenerator();
        $command = $this;

        $pageListener = $watcher->watch($generator->getPagesDir());
        $pageListener->anything(function($event, $resource, $path) use ($command, $output, $generator){
            $command->onChange($resource, $path, $output, $generator);
        });

        $templateListener = $watcher->watch($generator->getTemplatesDir());
        $templateListener->anything(function($event, $resource, $path) use ($command, $output, $generator){
            $command->onChange($resource, $path, $output, $generator);
        });

        $watcher->start();
    }

    public function onChange($resource, $path, OutputInterface $output, PageGenerator $generator){
        $output->writeln(sprintf('%s modified', $path));
        $generator->load();
        $affectedPages = $generator->generatePagesByResourcePath($path);
        if(count($affectedPages) > 0){
            foreach($affectedPages as $page){
                $output->writeln(sprintf('%s generated', $page->getPath()));
            }
        }

    }

}