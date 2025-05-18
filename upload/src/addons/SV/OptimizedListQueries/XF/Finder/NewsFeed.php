<?php

namespace SV\OptimizedListQueries\XF\Finder;



use XF\Entity\User as UserEntity;

/**
 * @extends \XF\Finder\NewsFeed
 */
class NewsFeed extends XFCP_NewsFeed
{
    public function beforeFeedId($feedId)
    {
        parent::beforeFeedId($feedId);

        if ($feedId)
        {
            $eventDate = $this->db->fetchOne('select event_date from xf_news_feed where news_feed_id <= ' . $this->db->quote($feedId) . ' order by news_feed_id desc limit 1');

            $this->where('event_date', '<=', $eventDate);
        }

        return $this;
    }

    public function forUser(UserEntity $user)
    {
        if ($user->user_id && $user->Profile->following)
        {
            if (!$this->indexHints)
            {
                $this->indexHint('use', 'userId_eventDate');
            }
            else
            {
                $badHint = 'FORCE INDEX (`event_date`)';
                // find 'force eventDate` and zap it.
                foreach($this->indexHints as &$indexHint)
                {
                    if ($indexHint === $badHint)
                    {
                        $indexHint = 'FORCE INDEX (`userId_eventDate`)';
                        break;
                    }
                }
            }
        }

        return parent::forUser($user);
    }
}