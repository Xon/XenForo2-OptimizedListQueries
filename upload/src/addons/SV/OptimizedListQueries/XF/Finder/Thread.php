<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\OptimizedListQueries\EarlyJoinFinderTrait;

/**
 * Extends \XF\Finder\Thread
 */
class Thread extends XFCP_Thread
{
    use EarlyJoinFinderTrait;

    /**
     * @return int
     */
    public function getEarlyJoinThreshold()
    {
        return (int)\XF::options()->sv_forumquery_threshold;
    }
}