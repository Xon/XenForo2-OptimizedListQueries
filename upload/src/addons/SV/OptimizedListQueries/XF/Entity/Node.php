<?php

namespace SV\OptimizedListQueries\XF\Entity;

use SV\StandardLib\Helper;
use XF\Repository\NodeType as NodeTypeRepository;

/**
 * @extends \XF\Entity\Node
 */
class Node extends XFCP_Node
{
    protected function _postSave()
    {
        parent::_postSave();

        if ($this->isInsert() || $this->isChanged('node_type_id'))
        {
            \XF::runLater(function (): void {
                $repo = Helper::repository(NodeTypeRepository::class);
                $repo->rebuildNodeTypeCache();
                $this->app()->container()->decache('nodeTypes');
            });
        }
    }

    protected function _postDelete()
    {
        parent::_postDelete();
        \XF::runLater(function (): void {
            $repo = Helper::repository(NodeTypeRepository::class);
            $repo->rebuildNodeTypeCache();
            $this->app()->container()->decache('nodeTypes');
        });
    }
}