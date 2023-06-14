<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\ConfigBundle\Block;

use Twig\Environment;

/**
 * Class ToolbarActions
 * @package ElectroForums\UiBundle\Block\Toolbar
 */
class ToolbarActions extends \ElectroForums\UiBundle\Block\Toolbar\ToolbarActions
{

    protected \ElectroForums\RouterBundle\Service\Url $url;

    public function __construct(
        Environment $environment,
        \ElectroForums\RouterBundle\Service\Url $url
    )
    {
        parent::__construct($environment);
        $this->url = $url;
    }

    public function getButtons(): array
    {
        return [
            ["buttonType" => "reset", "buttonTarget" => "button", "buttonAction" => "", "label" => "Reset"],
            ["buttonType" => "save", "buttonTarget" => "electroforums_config", "buttonAction" => $this->url->getUrlByRouteName("adminhtml_config_systemconfig_save"), "label" => "Save Configuration"]
        ];
    }
}