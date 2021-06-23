<?php

namespace SV\OptimizedListQueries\XFMG\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * Extends \XFMG\Finder\Album
 */
class Album extends XFCP_Album
{
    use EarlyJoinFinderTrait;

    /**
     * @return int
     */
    protected function getEarlyJoinThreshold()
    {
        return (int)(\XF::options()->sv_xfmg_album_threshold ?? -1);
    }
}