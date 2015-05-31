<?php

namespace amonger\Wrapper\Node;

class Link implements Node
{
    private $href;

    public function __construct($href)
    {
        $this->href = $href;
    }

    public function format()
    {
        return sprintf('<link rel="stylesheet" type="text/css" href="%s" />', $this->href);
    }

    public function position()
    {
        return self::HEADER;
    }
}