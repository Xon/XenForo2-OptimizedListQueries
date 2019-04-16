<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\Utils\Finder\EarlyJoinFinderTrait;

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
        $options = \XF::options();
        if (!isset($options->sv_convquery_threshold))
        {
            return -1;
        }

        return (int)$options->sv_convquery_threshold;
    }
}