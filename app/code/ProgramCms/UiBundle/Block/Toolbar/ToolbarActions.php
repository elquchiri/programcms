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
        $button = [];
        foreach($this->getData() as $buttonData) {
            if(is_string($buttonData)) {
                $dataSource = $this->objectManager->create($buttonData);
                $button = $dataSource->getData();
            }
            else if(is_array($buttonData)) {
                $button = $buttonData;
                // Button Action
                if (isset($buttonData['buttonAction']) && !empty($buttonData['buttonAction'])) {
                    $button['buttonAction'] = $this->url->getUrlByRouteName($buttonData['buttonAction']);
                }
            }

            // Button confirm modal
            $button['confirm'] = isset($button['confirm']) ? json_encode($button['confirm']) : '';

            $buttons[] = $button;
        }
        return $buttons;
    }
}