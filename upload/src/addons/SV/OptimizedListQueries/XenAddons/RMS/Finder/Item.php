<?php

namespace SV\OptimizedListQueries\XenAddons\RMS\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * @Extends \XenAddons\RMS\Finder\Item
 */
class Item extends XFCP_Item
{
    use EarlyJoinFinderTrait;

    protected function getEarlyJoinThreshold(int $offset = null, int $limit = null, array $options = []): int
    {
        if ($limit === null || $limit === 1 && $offset === 0)
        {
            return -1;
        }

        if (\XF::options()->svEarlyJoinRMSItems ?? true) {
            return 0;
        }

        return -1;
    }
}