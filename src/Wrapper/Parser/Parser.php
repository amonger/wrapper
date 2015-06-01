<?php

namespace amonger\Wrapper\Parser;

use amonger\Wrapper\Resource\Resource;

class Parser
{
    private $resource;

    /**
     * @param Resource $resource
     */
    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * This returns the file with the required fields called and extracted into
     * the file page
     *
     * @return string
     */
    public function renderRequireIncludes()
    {
        $resource = $this->resource;
        return $this->resource->applyCallback(function ($line, Resource $res) use ($resource) {
            $arr = preg_split('/require\ "/', $line);
            $arr = preg_split('/"\ /', $arr[1]);
            $requiredFile = $arr[0];
            $file = $resource->getClone();
            $file->setResource($res->getRelativePath() . '/' . $requiredFile);
            return $file->getHtml();
        });
    }
}
