<?php

use amonger\Wrapper\Parser\Parser;
use amonger\Wrapper\Node\Link;
use amonger\Wrapper\Resource\Resource;
use amonger\Wrapper\Wrapper;
use Vfs\FileSystem;
use Vfs\Node\Directory;
use Vfs\Node\File;

class WrapperTest extends PHPUnit_Framework_TestCase
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

    public function testGetHtmlFromFolder()
    {
        $this->fileSystem->get('/')->add('foo', $this->directory);

        $wrapper = new Wrapper('vfs://foo', new Resource());
        $result = $wrapper->getRoute('/index.html')->getHtml();
        $this->assertEquals($this->html, $result);

    }

    public function testParseRelativeRequire()
    {
        $subRequireHTML = '<?php require "test.php" ?>';
        $testPhp = "hello world";

        $this->directory = new Directory([
            'index.php'   => new File($subRequireHTML),
            'test.php' => new File($testPhp)
        ]);

        $this->fileSystem->get('/')->add('foo', $this->directory);

        $wrapper = new Wrapper('vfs://', new Resource());
        $resource = $wrapper->getRoute('/foo/index.php');
        $result = new Parser($resource);
        $html = $result->renderRequireIncludes();
        $this->assertContains($testPhp, $html);
    }

    public function testInjectLinkHrefIntoHead()
    {
        $this->fileSystem->get('/')->add('foo', $this->directory);

        $wrapper = new Wrapper('vfs://foo', new Resource());
        $result = $wrapper->getRoute('/index.html')->inject(new Link("//style.css"));
        $this->assertContains(
            '<link rel="stylesheet" type="text/css" href="//style.css" />',
            $result
        );
    }
}
