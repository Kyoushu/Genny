<?php

namespace Kyoushu\Genny\Tests\Bundle\Generator;

use Kyoushu\Genny\Bundle\Generator\PageGenerator;
use Kyoushu\Genny\Tests\Kernel;

class PageTest extends \PHPUnit_Framework_TestCase
{

    public function testGenerate()
    {
        $kernel = new Kernel('test', true);
        $kernel->boot();

        /** @var PageGenerator $generator */
        $generator = $kernel->getContainer()->get('genny.page_generator');

        $this->assertNotEmpty($generator->getDistDir(), 'dist dir should not be empty');

        $page = $generator->findPage('products/other_example_product');

        $html = $page->getHtml();
        $this->assertContains('<h1>My Other Example Product</h1>', $html);
        $this->assertContains('&pound;22', $html);

        $page->generate();

        $this->assertFileExists($page->getPath());

        $kernel->destroy();
    }

}