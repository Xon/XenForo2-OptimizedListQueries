<?php

namespace SV\OptimizedListQueries;

use SV\StandardLib\InstallerHelper;
use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
    use InstallerHelper;
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    public function postInstall(array &$stateChanges): void
    {
        /** @var \XF\Repository\NodeType $repo */
        $repo = \XF::repository('XF:NodeType');
        $repo->rebuildNodeTypeCache();
    }

    public function postUpgrade($previousVersion, array &$stateChanges): void
    {
        /** @var \XF\Repository\NodeType $repo */
        $repo = \XF::repository('XF:NodeType');
        $repo->rebuildNodeTypeCache();
    }

    public function uninstallStep1(): void
    {
        /** @var \XF\Repository\NodeType $repo */
        $repo = \XF::repository('XF:NodeType');
        $repo->rebuildNodeTypeCache();
    }
}
