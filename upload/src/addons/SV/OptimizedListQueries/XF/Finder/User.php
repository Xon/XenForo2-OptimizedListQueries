<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;

/**
 * Extends \XF\Finder\User
 */
class User extends XFCP_User
{
    use EarlyJoinFinderTrait;

    /**
     * @return int
     */
    public function getEarlyJoinThreshold()
    {
        return (int)(\XF::options()->sv_memberlist_threshold ?? -1);
    }
}