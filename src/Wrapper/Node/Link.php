<?php

namespace alanmonger\Wrapper\Node;

class Link implements Node
{
    private $href;

    public function __construct($href)
    {
        $this->href = $href;
    }

    public function format()
    {
        return sprintf('<link href="%s" />');
    }

    public function position()
    {
        return "footer";
    }
}