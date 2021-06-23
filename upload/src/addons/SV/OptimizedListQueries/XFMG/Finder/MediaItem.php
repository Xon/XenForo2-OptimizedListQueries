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
        return (int)(\XF::options()->sv_xfmg_mediaitem_threshold ?? -1);
    }
}