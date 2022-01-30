<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * Extends \XF\Finder\ConversationUser
 */
class ConversationUser extends XFCP_ConversationUser
{
    use EarlyJoinFinderTrait;

    protected function getEarlyJoinThreshold(int $offset = null, int $limit = null, array $options = []): int
    {
        return (int)(\XF::options()->sv_convlistquery_threshold ?? -1);
    }
}