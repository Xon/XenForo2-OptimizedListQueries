<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * Extends \XF\Finder\User
 */
class User extends XFCP_User
{
    use EarlyJoinFinderTrait;

    protected function getEarlyJoinThreshold(int $offset = null, int $limit = null, array $options = []): int
    {
        return (int)(\XF::options()->sv_memberlist_threshold ?? -1);
    }
}