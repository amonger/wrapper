<?php

namespace alanmonger\Wrapper\Node;

interface Node
{
    public function __construct($href);
    public function format();
    public function position();
}