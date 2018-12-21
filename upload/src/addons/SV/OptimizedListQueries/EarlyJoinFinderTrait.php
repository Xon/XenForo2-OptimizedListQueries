<?php

namespace SV\OptimizedListQueries;

use XF\Mvc\Entity\FinderExpression;
use XF\Mvc\Entity\Structure;

/**
 * @method int getEarlyJoinThreshold
 * @property \XF\Db\AbstractAdapter $db
 * @property Structure $structure
 */
trait EarlyJoinFinderTrait
{
    /**
     * @param array $options
     * @return string
     */
    public function getQuery(array $options = [])
    {
        $options = array_merge([
            'limit' => null,
            'offset' => null,
            'countOnly' => false,
            'fetchOnly' => null
        ], $options);

        $countOnly = $options['countOnly'];
        $fetchOnly = $options['fetchOnly'];
        $primaryKey = $this->structure->primaryKey;

        if ($countOnly || is_array($primaryKey))
        {
            return parent::getQuery($options);
        }

        $limit = $options['limit'];
        if ($limit === null)
        {
            $limit = $this->limit;
        }

        $offset = $options['offset'];
        if ($offset === null)
        {
            $offset = $this->offset;
        }

        $threshold = $this->getEarlyJoinThreshold();

        if ($threshold <= 0 || $offset < $threshold || $this->parentFinder)
        {
            return parent::getQuery($options);
        }

        $subQueryOptions = $options;
        $subQueryOptions['fetchOnly'] = [$primaryKey];

        $joinList = $this->joins;
        // do this before the outer-joins
        $innerSql = parent::getQuery($subQueryOptions);

        $defaultOrderSql = [];
        if (!$this->order && $this->defaultOrder)
        {
            foreach ($this->defaultOrder AS $defaultOrder)
            {
                $defaultOrderCol = $defaultOrder[0];

                if ($defaultOrderCol instanceof FinderExpression)
                {
                    /** @noinspection PhpParamsInspection */
                    $defaultOrderCol = $defaultOrderCol->renderSql($this, true);
                }
                else
                {
                    $defaultOrderCol = $this->columnSqlName($defaultOrderCol, true);
                }

                $defaultOrderSql[] = "$defaultOrderCol $defaultOrder[1]";
            }
        }

        $fetch = [];
        $coreTable = $this->structure->table;
        $joins = [];

        if (is_array($fetchOnly))
        {
            if (!$fetchOnly)
            {
                throw new \InvalidArgumentException("Must specify one or more specific columns to fetch");
            }

            foreach ($fetchOnly AS $key => $fetchValue)
            {
                $fetchSql = $this->columnSqlName(is_int($key) ? $fetchValue : $key);
                $fetch[] = $fetchSql . (!is_int($key) ? " AS '$fetchValue'" : '');
            }
        }
        else
        {
            $fetch[] = '`' . $coreTable . '`.*';
        }

        foreach ($joinList AS $join)
        {
            $joinType = $join['exists'] ? 'INNER' : 'LEFT';

            $joins[] = "$joinType JOIN `$join[table]` AS `$join[alias]` ON ($join[condition])";
            if ($join['fetch'] && !is_array($fetchOnly))
            {
                $fetch[] = "`$join[alias]`.*";
            }
        }

        if ($this->order)
        {
            $orderBy = 'ORDER BY ' . implode(', ', $this->order);
        }
        else if ($defaultOrderSql)
        {
            $orderBy = 'ORDER BY ' . implode(', ', $defaultOrderSql);
        }
        else
        {
            $orderBy = '';
        }

        $innerTable = "earlyJoinQuery_". $this->aliasCounter++;

        $q = $this->db->limit("
			SELECT " . implode(', ', $fetch) . "
			FROM (
			$innerSql
			) as `$innerTable`
			JOIN `$coreTable` ON (`$coreTable`.`$primaryKey` = `$innerTable`.`$primaryKey`)
			" . implode("\n", $joins) . "
			$orderBy
        ", $limit);

        return $q;
    }
}