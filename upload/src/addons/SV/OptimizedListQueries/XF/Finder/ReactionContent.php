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
        return (int)(\XF::options()->sv_reactionlist_threshold ?? -1);
    }
}