<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\Utils\Finder\EarlyJoinFinderTrait;

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
        $options = \XF::options();
        if (!isset($options->sv_forumquery_threshold))
        {
            return -1;
        }

        return (int)$options->sv_forumquery_threshold;
    }
}