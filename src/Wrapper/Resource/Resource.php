<?php

namespace amonger\Wrapper\Resource;

use amonger\Wrapper\Node\Node;

class Resource
{
    private $resource;

    public function __construct($resource = null)
    {
        $this->resource = ($resource !== null)
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
        $contents = '';
        if (!is_resource($this->resource)) {
            throw new \Exception;
        }
        while (($buffer = fgets($this->resource, 4096)) !== false) {
            if (strpos($buffer, $node->position()) !== false) {
                $buffer = $node->format() . PHP_EOL . $buffer;
            }
            $contents .= $buffer;
        }
        return $contents;
    }
}