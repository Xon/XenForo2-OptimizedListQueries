<?php

namespace SV\OptimizedListQueries\SV\Threadmarks\Finder;

use SV\StandardLib\Finder\EarlyJoinFinderTrait;
use SV\Threadmarks\Entity\ThreadmarkContainerInterface;
use XF\Mvc\Entity\Entity;

/**
 * Extends \SV\Threadmarks\Finder\Threadmark
 */
class Threadmark extends XFCP_Threadmark
{
    use EarlyJoinFinderTrait;

    /** @var bool */
    protected $largeThreadmarkCollection = false;

    /** @var bool */
    protected $isThreadmarkDateOrder = false;

    public function order($field, $direction = 'ASC')
    {
        if ($field === 'threadmark_date')
        {
            $this->isThreadmarkDateOrder = true;
        }
        return parent::order($field, $direction);
    }

    /**
     * @param Entity|ThreadmarkContainerInterface $container
     * @param bool                         $loadWith
     * @return \SV\Threadmarks\Finder\Threadmark
     */
    public function withContentForContainer(ThreadmarkContainerInterface $container, $loadWith = false)
    {
        if ($container->threadmark_count > 100)
        {
            $this->largeThreadmarkCollection = true;
        }

        return parent::withContentForContainer($container, $loadWith);
    }

    protected function getEarlyJoinThreshold(int $offset = null, int $limit = null, array $options = []): int
    {
        return ($this->largeThreadmarkCollection && $this->isThreadmarkDateOrder) ? 0 : -1;
    }
}