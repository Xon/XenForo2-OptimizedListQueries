<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\Utils\Finder\EarlyJoinFinderTrait3;

/**
 * Extends \XF\Finder\Thread
 */
class Thread extends XFCP_Thread
{
    use EarlyJoinFinderTrait3;

    /**
     * @return int
     */
    public function getEarlyJoinThreshold()
    {
        $options = \XF::options();
        if (!isset($options->sv_forumquery_threshold))
        {
            return -1;
        }

        return (int)$options->sv_forumquery_threshold;
    }
}