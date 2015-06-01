<?php

namespace amonger\Wrapper;

use amonger\Wrapper\Resource\Resource;

class Wrapper
{
    private $directory;
    private $resource;

    public function __construct($directory, Resource $resource)
    {
        $this->directory = $directory;
        $this->resource = $resource;
    }

    public function getRoute($route)
    {
        $resource = $this->makeResource();
        $resource->setResource($this->directory . $route);
        return $resource;
    }

    private function makeResource()
    {
        return clone $this->resource;
    }
}
