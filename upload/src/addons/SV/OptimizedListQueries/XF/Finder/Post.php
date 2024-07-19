<?php

namespace SV\OptimizedListQueries\XF\Finder;

use function array_shift;
use function count;
use function strpos;

/**
 * @Extends \XF\Finder\Post
 */
class Post extends XFCP_Post
{
    /**
     * XF2.1.8 and earlier sort by position/post_date when getting latest replies, this causes an unexpectedly poor query performance
     */
    public function patchPostSortOrder()
    {
        $order = $this->order;
        if (count($order) >= 2)
        {
            $postDateField = $this->columnSqlName('post_date');
            $positionField = $this->columnSqlName('position');
            if (strpos($order[0], $positionField) === 0 &&
                strpos($order[1], $postDateField) === 0)
            {
                array_shift($order);
                $this->order = $order;
            }
        }
    }
}