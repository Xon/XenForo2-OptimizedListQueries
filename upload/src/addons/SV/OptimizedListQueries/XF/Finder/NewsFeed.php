<?php

namespace SV\OptimizedListQueries\XF\Finder;



/**
 * Extends \XF\Finder\NewsFeed
 */
class NewsFeed extends XFCP_NewsFeed
{
    public function beforeFeedId($feedId)
    {
        parent::beforeFeedId($feedId);

        if ($feedId)
        {
            $eventDate = $this->_db->fetchOne('select event_date from xf_news_feed where news_feed_id < ' . $this->db->quote($feedId) . ' limit 1');

            $this->where('event_date', '<=', $eventDate);
        }

        return $this;
    }

    public function forUser(\XF\Entity\User $user)
    {
        if ($user->user_id && $user->Profile->following)
        {
            $this->indexHint('use', 'userId_eventDate');
        }

        return parent::forUser($user);
    }
}