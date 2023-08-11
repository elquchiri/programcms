<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Toolbar;

use ProgramCms\CoreBundle\Model\ObjectManager;

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
    protected ObjectManager $objectManager;

    /**
     * ToolbarActions constructor.
     * @param \ProgramCms\CoreBundle\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        ObjectManager $objectManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->url = $context->getUrl();
        $this->objectManager = $objectManager;
    }

    /**
     * Process buttons
     * @return array
     */
    public function getButtons(): array
    {
        // Transform url names to paths
        $buttons = [];
        foreach($this->getData() as $button) {
            if(is_string($button)) {
                $dataSource = $this->objectManager->create($button);
                $buttons[] = $dataSource->getData();
            }
            else if(is_array($button)) {
                if (isset($button['buttonAction']) && !empty($button['buttonAction'])) {
                    $button['buttonAction'] = $this->url->getUrlByRouteName($button['buttonAction']);
                }
                $buttons[] = $button;
            }
        }
        return $buttons;
    }
}