<?php

namespace SV\OptimizedListQueries\XFMG\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * @extends \XFMG\Finder\MediaItem
 */
class MediaItem extends XFCP_MediaItem
{
    use EarlyJoinFinderTrait;

    protected function getEarlyJoinThreshold(?int $offset = null, ?int $limit = null, array $options = []): int
    {
        return (int)(\XF::options()->sv_xfmg_mediaitem_threshold ?? -1);
    }
}