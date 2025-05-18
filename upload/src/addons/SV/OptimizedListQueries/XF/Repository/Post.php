<?php

namespace SV\OptimizedListQueries\XF\Repository;

use SV\OptimizedListQueries\XF\Finder\Post as ExtendedPostFinder;
use XF\Entity\Thread as ThreadEntity;
use function is_callable;

/**
 * @extends \XF\Repository\Post
 */
class Post extends XFCP_Post
{
    public function findNewestPostsInThread(ThreadEntity $thread, $newerThan, array $limits = [])
    {
        /** @var ExtendedPostFinder $finder */
        $finder = parent::findNewestPostsInThread($thread, $newerThan, $limits);
        if (is_callable([$finder, 'patchPostSortOrder']))
        {
            $finder->patchPostSortOrder();
        }

        return $finder;
    }

    public function findNextPostsInThread(ThreadEntity $thread, $newerThan, array $limits = [])
    {
        /** @var ExtendedPostFinder $finder */
        $finder = parent::findNextPostsInThread($thread, $newerThan, $limits);
        if (is_callable([$finder, 'patchPostSortOrder']))
        {
            $finder->patchPostSortOrder();
        }

        return $finder;
    }
}