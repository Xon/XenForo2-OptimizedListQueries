<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\StandardLib\Finder\ComplexJoinTrait;

/**
 * @extends \XF\Finder\Node
 */
class Node extends XFCP_Node
{
    use ComplexJoinTrait;
}