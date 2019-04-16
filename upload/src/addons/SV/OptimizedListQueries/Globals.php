<?php

namespace SV\OptimizedListQueries;


// This class is used to encapsulate global state between layers without using $GLOBAL[] or
// relying on the consumer being loaded correctly by the dynamic class autoloader
class Globals
{
    public static $shimNodeList = false;

    private function __construct() {}
}