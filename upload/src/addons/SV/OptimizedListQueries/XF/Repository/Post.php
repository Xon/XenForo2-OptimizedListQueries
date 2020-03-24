<?php

namespace SV\OptimizedListQueries\XF\Repository;



/**
 * Extends \XF\Repository\Post
 */
class Post extends XFCP_Post
{
    public function findNewestPostsInThread(\XF\Entity\Thread $thread, $newerThan, array $limits = [])
    {
        /** @var \SV\OptimizedListQueries\XF\Finder\Post $finder */
        $finder = parent::findNewestPostsInThread($thread, $newerThan, $limits);
        if (\is_callable([$finder, 'patchPostSortOrder']))
        {
            $finder->patchPostSortOrder();
        }

        return $finder;
    }

    public function findNextPostsInThread(\XF\Entity\Thread $thread, $newerThan, array $limits = [])
    {
        /** @var \SV\OptimizedListQueries\XF\Finder\Post $finder */
        $finder = parent::findNextPostsInThread($thread, $newerThan, $limits);
        if (\is_callable([$finder, 'patchPostSortOrder']))
        {
            $finder->patchPostSortOrder();
        }

        return $finder;
    }
}