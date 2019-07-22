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
            $eventDate = $this->db->fetchOne('select event_date from xf_news_feed where news_feed_id <= ' . $this->db->quote($feedId) . ' order by news_feed_id desc limit 1');

            $this->where('event_date', '<=', $eventDate);
        }

        return $this;
    }

    public function forUser(\XF\Entity\User $user)
    {
        if ($user->user_id && $user->Profile->following)
        {
            if (!$this->indexHints)
            {
                $this->indexHint('use', 'userId_eventDate');
            }
            else
            {
                $badHint = "FORCE INDEX (`eventDate`)";
                // find 'force eventDate` and zap it.
                foreach($this->indexHints as &$indexHint)
                {
                    if ($indexHint === $badHint)
                    {
                        $indexHint = "FORCE INDEX (`userId_eventDate`)";
                        break;
                    }
                }
            }
        }

        return parent::forUser($user);
    }
}