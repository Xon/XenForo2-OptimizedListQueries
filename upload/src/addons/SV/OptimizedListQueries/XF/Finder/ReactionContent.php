<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * Extends \XF\Finder\ReactionContent
 */
class ReactionContent extends XFCP_ReactionContent
{
    use EarlyJoinFinderTrait;

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