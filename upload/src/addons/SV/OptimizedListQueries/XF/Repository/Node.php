<?php

namespace SV\OptimizedListQueries\XF\Repository;

use SV\OptimizedListQueries\Globals;
use SV\OptimizedListQueries\XF\Finder\Node as ExtendedNodeFinder;
use SV\StandardLib\Helper;
use XF\Entity\Node as NodeEntity;
use XF\Finder\Node as NodeFinder;
use XF\Mvc\Entity\Entity;
use XF\Repository\NodeType as NodeTypeRepository;
use function reset;

/**
 * @extends \XF\Repository\Node
 */
class Node extends XFCP_Node
{
    public function getNodeList(?NodeEntity $withinNode = null)
    {
        if ($withinNode && !$withinNode->hasChildren())
        {
            return $this->em->getEmptyCollection();
        }
        if (Globals::$shimNodeList ?? false)
        {
            /** @var ExtendedNodeFinder $nodeFinder */
            $nodeFinder = $this->findNodesForList($withinNode);

            $container = $this->app()->container();
            $nodeTypes = $container->offsetGet('nodeTypes');
            // valid the usage count is including in the node-type
            $nodeType = reset($nodeTypes);
            if (!isset($nodeType['use']) || !isset($nodeType['entity_identifier']))
            {
                $repo = Helper::repository(NodeTypeRepository::class);
                $nodeTypes = $repo->rebuildNodeTypeCache();
                $this->app()->container()->decache('nodeTypes');
            }

            foreach ($nodeTypes AS $nodeType)
            {
                $entityIdent = $nodeType['entity_identifier'];
                $entityClass = $this->em->getEntityClassName($entityIdent);
                $structure = $this->em->getEntityStructure($entityIdent);

                if (isset($nodeType['use']) && !$nodeType['use'])
                {
                    continue;
                }

                // require that the join via node_id
                if (empty($structure->columns['node_id']))
                {
                    continue;
                }

                $extraWith = $entityClass::getListedWith();

                $nodeFinder->complexJoin([
                    'entity' => $entityIdent,
                    'type' => Entity::TO_ONE,
                    'conditions' => 'node_id',
                    'primary' => true,
                    'with' => $extraWith,
                ]);
            }

            $nodes = $nodeFinder->fetch();
            return $this->filterViewable($nodes);
        }

        return parent::getNodeList($withinNode);
    }

    public function loadNodeTypeDataForNodes($nodes)
    {
        if (Globals::$shimNodeList ?? false)
        {
            return $nodes;
        }

        return parent::loadNodeTypeDataForNodes($nodes);
    }

    public function getFullNodeList(?NodeEntity $withinNode = null, $with = null)
    {
        if (Globals::$shimNodeList ?? false)
        {
            /** @var ExtendedNodeFinder $nodeFinder */
            $nodeFinder = Helper::finder(NodeFinder::class);
            $nodeFinder = $nodeFinder->order('lft');
            if ($withinNode)
            {
                $nodeFinder->descendantOf($withinNode);
            }
            if ($with)
            {
                $nodeFinder->with($with);
            }

            $container = $this->app()->container();
            $nodeTypes = $container->offsetGet('nodeTypes');
            // valid the usage count is including in the node-type
            $nodeType = reset($nodeTypes);
            if (!isset($nodeType['use']))
            {
                $repo = Helper::repository(NodeTypeRepository::class);
                $nodeTypes = $repo->rebuildNodeTypeCache();
                $this->app()->container()->decache('nodeTypes');
            }

            foreach ($nodeTypes AS $nodeType)
            {
                $entityIdent = $nodeType['entity_identifier'];
                $entityClass = $this->em->getEntityClassName($entityIdent);
                $structure = $this->em->getEntityStructure($entityIdent);

                if (isset($nodeType['use']) && !$nodeType['use'])
                {
                    continue;
                }

                // require that the join via node_id
                if (empty($structure->columns['node_id']))
                {
                    continue;
                }

                $extraWith = $entityClass::getListedWith();

                $nodeFinder->complexJoin([
                    'entity' => $entityIdent,
                    'type' => Entity::TO_ONE,
                    'conditions' => 'node_id',
                    'primary' => true,
                    'with' => $extraWith,
                ]);
            }

            return  $nodeFinder->fetch();
        }

        return parent::getFullNodeList($withinNode, $with);
    }
}