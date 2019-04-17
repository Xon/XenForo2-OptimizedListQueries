<?php

namespace SV\OptimizedListQueries;

use SV\Utils\InstallerHelper;
use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
    // from https://github.com/Xon/XenForo2-Utils cloned to src/addons/SV/Utils
    use InstallerHelper;
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    public function postInstall(array &$stateChanges)
    {
        /** @var \XF\Repository\NodeType $repo */
        $repo = \XF::repository('XF:NodeType');
        $repo->rebuildNodeTypeCache();
    }

    public function postUpgrade($previousVersion, array &$stateChanges)
    {
        /** @var \XF\Repository\NodeType $repo */
        $repo = \XF::repository('XF:NodeType');
        $repo->rebuildNodeTypeCache();
    }

    public function uninstallStep1()
    {
        /** @var \XF\Repository\NodeType $repo */
        $repo = \XF::repository('XF:NodeType');
        $repo->rebuildNodeTypeCache();
    }
}
