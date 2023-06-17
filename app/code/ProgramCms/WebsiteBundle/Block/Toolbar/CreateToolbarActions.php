<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Block\Toolbar;

use Twig\Environment;

/**
 * Class ToolbarActions
 * @package ProgramCms\UiBundle\Block\Toolbar
 */
class CreateToolbarActions extends \ProgramCms\UiBundle\Block\Toolbar\ToolbarActions
{

    protected \ProgramCms\RouterBundle\Service\Url $url;

    public function __construct(
        Environment $environment,
        \ProgramCms\RouterBundle\Service\Url $url
    )
    {
        parent::__construct($environment);
        $this->url = $url;
    }

    public function getButtons(): array
    {
        return [
            ["buttonType" => "back", "buttonTarget" => "button", "buttonAction" => "", "label" => "Go Back"],
            ["buttonType" => "reset", "buttonTarget" => "button", "buttonAction" => "", "label" => "Reset"],
            ["buttonType" => "save", "buttonTarget" => "programcms_config", "buttonAction" => $this->url->getUrlByRouteName("adminhtml_config_systemconfig_save"), "label" => "Save Website"]
        ];
    }
}