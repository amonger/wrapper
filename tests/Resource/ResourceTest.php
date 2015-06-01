<?php


use amonger\Wrapper\Resource\Resource;
use Vfs\FileSystem;
use Vfs\Node\Directory;
use Vfs\Node\File;

class ResourceTest extends PHPUnit_Framework_TestCase
{
    private $directory;
    private $html;
    private $fileSystem = null;

    public function setUp()
    {
        $this->html = '
            <!doctype html>
            <html>
                <head>
                </head>
                <body>
                </body>
            </html>
        ';
        $this->directory = new Directory(['index.html' => new File($this->html)]);
        $this->fileSystem = FileSystem::factory('vfs://');
    }

    public function tearDown()
    {
        $this->fileSystem->unmount();
    }

    public function testGetRelativeDirectory()
    {
        $this->fileSystem->get('/')->add('foo', $this->directory);

        $resource = new Resource();
        $resource->setResource('vfs://foo/index.html');
        $this->assertEquals('vfs://foo', $resource->getRelativePath());

    }
}
