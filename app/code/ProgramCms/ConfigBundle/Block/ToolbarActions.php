<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Block;

use Twig\Environment;

/**
 * Class ToolbarActions
 * @package ProgramCms\UiBundle\Block\Toolbar
 */
class ToolbarActions extends \ProgramCms\UiBundle\Block\Toolbar\ToolbarActions
{

    protected \ProgramCms\RouterBundle\Service\Url $url;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\RouterBundle\Service\Url $url,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->url = $url;
    }

    public function getButtons(): array
    {
        return [
            ["buttonType" => "reset", "buttonTarget" => "button", "buttonAction" => "", "label" => "Reset"],
            ["buttonType" => "save", "buttonTarget" => "programcms_config", "buttonAction" => $this->url->getUrlByRouteName("adminhtml_config_systemconfig_save"), "label" => "Save Configuration"]
        ];
    }
}