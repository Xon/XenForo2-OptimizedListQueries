<?php

namespace SV\OptimizedListQueries\XFMG\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * @extends \XFMG\Finder\Album
 */
class Album extends XFCP_Album
{
    use EarlyJoinFinderTrait;

    protected function getEarlyJoinThreshold(?int $offset = null, ?int $limit = null, array $options = []): int
    {
        return (int)(\XF::options()->sv_xfmg_album_threshold ?? -1);
    }
}