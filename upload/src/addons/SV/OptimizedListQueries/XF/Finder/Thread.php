<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * @Extends \XF\Finder\Thread
 */
class Thread extends XFCP_Thread
{
    use EarlyJoinFinderTrait;

    protected function getEarlyJoinThreshold(?int $offset = null, ?int $limit = null, array $options = []): int
    {
        return (int)(\XF::options()->sv_forumquery_threshold ?? -1);
    }
}