<?php

namespace SV\OptimizedListQueries\Audentio\Feeds\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * @Extends \Audentio\Feeds\Finder\ThreadFeedEntry
 */
class ThreadFeedEntry extends XFCP_ThreadFeedEntry
{
    use EarlyJoinFinderTrait;

    protected function getEarlyJoinThreshold(?int $offset = null, ?int $limit = null, array $options = []): int
    {
        return (int)(\XF::options()->sv_aud_threadfeed_threshold ?? -1);
    }
}