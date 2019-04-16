<?php

namespace SV\OptimizedListQueries\XF\Repository;

/**
 * Extends \XF\Repository\NodeType
 */
class NodeType extends XFCP_NodeType
{
    public function getNodeTypeCacheData()
    {
        $output = parent::getNodeTypeCacheData();

        $kvp = $this->db()->fetchPairs('select node_type_id, count(*) from xf_node group by node_type_id');
        foreach($kvp as $nodeTypeId => $usageCount)
        {
            $output[$nodeTypeId]['use'] = $usageCount;
        }

        return $output;
    }
}