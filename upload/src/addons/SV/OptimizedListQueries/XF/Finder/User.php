<?php

namespace SV\OptimizedListQueries\XF\Finder;

use SV\Utils\Finder\EarlyJoinFinderTrait3;

/**
 * Extends \XF\Finder\User
 */
class User extends XFCP_User
{
    use EarlyJoinFinderTrait3;

    /**
     * @return int
     */
    public function getEarlyJoinThreshold()
    {
        $options = \XF::options();
        if (!isset($options->sv_memberlist_threshold))
        {
            return -1;
        }

        return (int)$options->sv_memberlist_threshold;
    }
}