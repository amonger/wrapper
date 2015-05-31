<?php

namespace alanmonger\Wrapper\Node;

class Script implements Node
{
    private $href;

    public function __construct($href)
    {
        $this->href = $href;
    }

    public function format()
    {
        return sprintf('<script src="%s"></script>', $this->href);
    }

    public function position()
    {
        return "header";
    }
}