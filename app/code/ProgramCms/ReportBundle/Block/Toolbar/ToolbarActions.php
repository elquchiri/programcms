<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ReportBundle\Block\Toolbar;

use ProgramCms\CoreBundle\Model\ObjectManager;

/**
 * Class ToolbarActions
 * @package ProgramCms\ReportBundle\Block\Toolbar
 */
class ToolbarActions extends \ProgramCms\UiBundle\Block\Toolbar\ToolbarActions
{

    protected \ProgramCms\RouterBundle\Service\Url $url;


    public function getButtons(): array
    {
        return [
            ["buttonType" => "save", "buttonTarget" => "programcms_config", "buttonAction" => "", "label" => "Reload Data"]
        ];
    }
}