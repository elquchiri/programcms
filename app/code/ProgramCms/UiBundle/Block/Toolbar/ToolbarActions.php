<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Toolbar;

/**
 * Class ToolbarActions
 * @package ProgramCms\UiBundle\Block\Toolbar
 */
class ToolbarActions extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/toolbar/toolbar_buttons.html.twig";
    /**
     * @var \ProgramCms\RouterBundle\Service\Url
     */
    protected \ProgramCms\RouterBundle\Service\Url $url;

    /**
     * ToolbarActions constructor.
     * @param \ProgramCms\CoreBundle\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->url = $context->getUrl();
    }

    /**
     * Process buttons
     * @return array
     */
    public function getButtons(): array
    {
        // Transform url names to paths
        foreach($this->getData() as $button) {
            if(isset($button['buttonAction']) && !empty($button['buttonAction'])) {
                $button['buttonAction'] = $this->url->getUrlByRouteName($button['buttonAction']);
            }
        }
        return $this->getData();
    }
}