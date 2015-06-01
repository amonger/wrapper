<?php

namespace amonger\Wrapper\Resource;

use amonger\Wrapper\Node\Node;
use closure;

class Resource
{
    private $path;
    private $resource;

    /**
     * @param string $path
     */
    public function setResource($path)
    {
        $this->path = $path;
        $this->resource = fopen($path, 'rw');
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getRelativePath()
    {
        $split = explode('/', $this->path);
        array_pop($split);
        return implode('/', $split);
    }

    /**
     * @return string
     * @throws \Exception
     */
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

    /**
     * @param callable $fn
     * @return string
     * @throws \Exception
     */
    public function applyCallback(closure $fn)
    {
        $contents = '';
        if (!is_resource($this->resource)) {
            throw new \Exception;
        }
        while (!feof($this->resource)) {
            $line = fread($this->resource, 8192);
            $contents .= $fn($line, $this);
        }
        return $contents;
    }

    /**
     * @param Node $node
     * @return string
     * @throws \Exception
     */
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

    /**
     * @return Resource
     */
    public function getClone()
    {
        return clone $this;
    }
}
