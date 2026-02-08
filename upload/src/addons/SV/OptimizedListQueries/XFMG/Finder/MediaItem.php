<?php

namespace SV\OptimizedListQueries\XFMG\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;
use SV\StandardLib\Helper;

/**
 * @extends \XFMG\Finder\MediaItem
 */
class MediaItem extends XFCP_MediaItem
{
    use EarlyJoinFinderTrait;

    protected function getEarlyJoinThreshold(?int $offset = null, ?int $limit = null, array $options = []): int
    {
        return \XF::options()->sv_xfmg_mediaitem_threshold ?? -1;
    }

    public function fetchDeferred(?int $limit = null, ?int $offset = null): \XF\Mvc\Entity\AbstractCollection
    {
        if ((\XF::options()->sv_xfmg_album_threshold ?? -1) >= 0)
        {
            return $this->fetch($limit, $offset);
        }

        return parent::fetchDeferred($limit, $offset);
    }
}