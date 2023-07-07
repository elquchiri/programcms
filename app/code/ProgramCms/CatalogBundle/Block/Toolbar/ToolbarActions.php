<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Block\Toolbar;

/**
 * Class ToolbarActions
 * @package ProgramCms\UiBundle\Block\Toolbar
 */
class ToolbarActions extends \ProgramCms\UiBundle\Block\Toolbar\ToolbarActions
{

    protected \ProgramCms\RouterBundle\Service\Url $url;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->url = $context->getUrl();
    }

    public function getButtons(): array
    {
        return [
            ["buttonType" => "reset", "buttonTarget" => "button", "buttonAction" => "", "label" => "Reset"],
            ["buttonType" => "save", "buttonTarget" => "programcms_config", "buttonAction" => $this->url->getUrlByRouteName("adminhtml_catalog_category_save"), "label" => "Save Category"]
        ];
    }
}