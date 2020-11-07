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
        $options = \XF::options();
        if (!isset($options->sv_xfmg_album_threshold))
        {
            return -1;
        }

        return (int)$options->sv_xfmg_album_threshold;
    }
}