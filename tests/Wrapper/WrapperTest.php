<?php

use amonger\Wrapper\Resource\Resource;
use amonger\Wrapper\Wrapper;
use Vfs\FileSystem;
use Vfs\Node\Directory;
use Vfs\Node\File;

class WrapperTest extends PHPUnit_Framework_TestCase
{
    private $fileSystem;

    public function setUp()
    {
        $this->fileSystem = FileSystem::factory('vfs://');
    }

    public function testGetHtmlFromFolder()
    {
        $html = '
            <!doctype html>
            <html>
                <head>
                </head>
                <body>
                </body>
            </html>
        ';

        $foo = new Directory(['index.html' => new File($html)]);
        $this->fileSystem->get('/')->add('foo', $foo);

        $wrapper = new Wrapper('vfs://foo', new Resource());
        $result = $wrapper->getRoute('/index.html')->getHtml();
        $this->assertEquals($html, $result);
    }

}
