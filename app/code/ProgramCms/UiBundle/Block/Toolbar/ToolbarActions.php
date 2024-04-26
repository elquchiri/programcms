<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Block\Toolbar;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\RouterBundle\Service\Url;
use ReflectionException;

/**
 * Class ToolbarActions
 * @package ProgramCms\UiBundle\Block\Toolbar
 */
class ToolbarActions extends Template
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUiBundle/toolbar/toolbar_buttons.html.twig";

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * ToolbarActions constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param array $data
     */
    public function __construct(
        Context $context,
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
     * @throws ReflectionException
     */
    public function getButtons(): array
    {
        // Transform url names to paths
        $buttons = [];
        foreach($this->getData() as $buttonKey => $buttonData) {
            if($buttonKey === 'bundle_name') {
                continue;
            }

            if(is_string($buttonData) && !empty($buttonData)) {
                $dataSource = $this->objectManager->create($buttonData);
                $button = $dataSource->getData();
                $button['class'] = $button['class'] ?? ($button['buttonType'] == 'save' ? 'btn-primary' : '');
                $button['confirm'] = isset($button['confirm']) ? json_encode($button['confirm']) : false;               $buttons[] = $button;
            }
        }
        return $buttons;
    }
}