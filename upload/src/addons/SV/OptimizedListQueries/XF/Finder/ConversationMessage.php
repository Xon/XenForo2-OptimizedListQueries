<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * @Extends \XF\Finder\ConversationMessage
 */
class ConversationMessage extends XFCP_ConversationMessage
{
    use EarlyJoinFinderTrait;

    protected function getEarlyJoinThreshold(?int $offset = null, ?int $limit = null, array $options = []): int
    {
        return (int)(\XF::options()->sv_convquery_threshold ?? -1);
    }
}