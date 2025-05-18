<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * @extends \XF\Finder\ConversationUser
 */
class ConversationUser extends XFCP_ConversationUser
{
    use EarlyJoinFinderTrait;

    protected function getEarlyJoinThreshold(?int $offset = null, ?int $limit = null, array $options = []): int
    {
        if ($limit === null || $limit === 1 && $offset === 0)
        {
            return -1;
        }
        return (int)(\XF::options()->sv_convlistquery_threshold ?? -1);
    }
}