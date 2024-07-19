<?php

namespace SV\OptimizedListQueries;

use SV\StandardLib\Helper;
use SV\StandardLib\InstallerHelper;
use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Repository\NodeType as NodeTypeRepo;

class Setup extends AbstractSetup
{
    use InstallerHelper;
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    public function postInstall(array &$stateChanges): void
    {
        $repo = Helper::repository(NodeTypeRepo::class);
        $repo->rebuildNodeTypeCache();
    }

    public function postUpgrade($previousVersion, array &$stateChanges): void
    {
        $repo = Helper::repository(NodeTypeRepo::class);
        $repo->rebuildNodeTypeCache();
    }

    public function uninstallStep1(): void
    {
        $repo = Helper::repository(NodeTypeRepo::class);
        $repo->rebuildNodeTypeCache();
    }
}
