<?php

namespace SV\OptimizedListQueries\XF\Pub\Controller;

use SV\OptimizedListQueries\Globals;
use XF\Mvc\ParameterBag;

/**
 * @extends \XF\Pub\Controller\Forum
 */
class Forum extends XFCP_Forum
{
    public function actionList(ParameterBag $params)
    {
        Globals::$shimNodeList = (bool)(\XF::options()->svNodeListQueryChange ?? true);
        try
        {
            return parent::actionList($params);
        }
        finally
        {
            Globals::$shimNodeList = false;
        }
    }

    public function actionForum(ParameterBag $params)
    {
        Globals::$shimNodeList = (bool)(\XF::options()->svNodeListQueryChange ?? true);
        try
        {
            return parent::actionForum($params);
        }
        finally
        {
            Globals::$shimNodeList = false;
        }
    }
}