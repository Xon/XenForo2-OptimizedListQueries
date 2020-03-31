<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\Utils\Finder\EarlyJoinFinderTrait4;

/**
 * Extends \XF\Finder\ReactionContent
 */
class ReactionContent extends XFCP_ReactionContent
{
    use EarlyJoinFinderTrait4;

    /**
     * @return int
     */
    protected function getEarlyJoinThreshold()
    {
        $options = \XF::options();
        if (!isset($options->sv_reactionlist_threshold))
        {
            return -1;
        }

        return (int)$options->sv_reactionlist_threshold;
    }
}