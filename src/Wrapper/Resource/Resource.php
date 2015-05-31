<?php

namespace amonger\Wrapper\Resource;

use alanmonger\Wrapper\Node\Node;

class Resource
{
    private $resource;

    public function __construct($resource = "")
    {
        $this->resource = ($resource !== "")
            ? fopen($resource, 'rw') : $resource;
    }

    public function setResource($resource)
    {
        $this->resource = fopen($resource, 'rw');
    }

    public function getHTML()
    {
        $contents = '';
        if (!is_resource($this->resource)) {
            throw new \Exception;
        }
        while (!feof($this->resource)) {
            $contents .= fread($this->resource, 8192);
        }
        return $contents;
    }

    public function inject(Node $node)
    {
        $html = $this->getHTML();

    }
}