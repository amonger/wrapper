<?php

namespace amonger\Wrapper\Resource;

class Resource
{
    private $path;

    public function __construct($path = "")
    {
        $this->path = $path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getHTML()
    {
        return file_get_contents($this->path);
    }
}