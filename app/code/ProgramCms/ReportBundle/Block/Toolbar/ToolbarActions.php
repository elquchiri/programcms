<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ReportBundle\Block\Toolbar;

/**
 * Class ToolbarActions
 * @package ProgramCms\ReportBundle\Block\Toolbar
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
            ["buttonType" => "save", "buttonTarget" => "programcms_config", "buttonAction" => $this->url->getUrlByRouteName("adminhtml_category_index_save"), "label" => "Reload Data"]
        ];
    }
}