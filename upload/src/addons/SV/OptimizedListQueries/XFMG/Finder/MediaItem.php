<?php

namespace SV\OptimizedListQueries\XFMG\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * Extends \XFMG\Finder\MediaItem
 */
class MediaItem extends XFCP_MediaItem
{
    use EarlyJoinFinderTrait;

    /**
     * @return int
     */
    protected function getEarlyJoinThreshold()
    {
        $options = \XF::options();
        if (!isset($options->sv_xfmg_mediaitem_threshold))
        {
            return -1;
        }

        return (int)$options->sv_xfmg_mediaitem_threshold;
    }
}