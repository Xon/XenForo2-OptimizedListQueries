<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\OptimizedListQueries\EarlyJoinFinderTrait;

/**
 * Extends \XF\Finder\ConversationMessage
 */
class ConversationMessage extends XFCP_ConversationMessage
{
    use EarlyJoinFinderTrait;

    /**
     * @return int
     */
    public function getEarlyJoinThreshold()
    {
        return (int)\XF::options()->sv_convquery_threshold;
    }
}