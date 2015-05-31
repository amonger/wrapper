<?php

namespace amonger\Wrapper\Node;

interface Node
{
    const HEADER = "</head>";
    const FOOTER = "</body>";

    public function __construct($href);

    public function format();

    public function position();
}