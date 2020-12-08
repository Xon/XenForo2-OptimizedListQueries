<?php

namespace SV\OptimizedListQueries\XF\Entity;

/**
 * Extends \XF\Entity\Node
 */
class Node extends XFCP_Node
{
    protected function _postSave()
    {
        parent::_postSave();

        if ($this->isInsert() || $this->isChanged('node_type_id'))
        {
            \XF::runLater(function () {
                /** @var \XF\Repository\NodeType $repo */
                $repo = \XF::repository('XF:NodeType');
                $repo->rebuildNodeTypeCache();
                $this->app()->container()->decache('nodeTypes');
            });
        }
    }

    protected function _postDelete()
    {
        parent::_postDelete();
        \XF::runLater(function () {
            /** @var \XF\Repository\NodeType $repo */
            $repo = \XF::repository('XF:NodeType');
            $repo->rebuildNodeTypeCache();
            $this->app()->container()->decache('nodeTypes');
        });
    }
}