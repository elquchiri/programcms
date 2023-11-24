<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Block;

use ProgramCms\ConfigBundle\Model\ConfigSerializer;
use ProgramCms\ConfigBundle\Model\Structure\Element\Section;
use ProgramCms\ConfigBundle\Model\Structure\Element\Tab;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use ProgramCms\RouterBundle\Service\Request;

/**
 * Class ConfigTabs
 * @package ProgramCms\ConfigBundle\Block
 */
class ConfigTabs extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * @var ConfigSerializer
     */
    protected ConfigSerializer $configSerializer;
    /**
     * @var Request
     */
    protected Request $request;
    /**
     * @var string|mixed
     */
    protected string $_currentSectionId;

    /**
     * ConfigTabs constructor.
     * @param Context $context
     * @param ConfigSerializer $configSerializer
     * @param array $data
     */
    public function __construct(
        Context $context,
        ConfigSerializer $configSerializer,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->configSerializer = $configSerializer;
        $this->_currentSectionId = $this->getRequest()->getParam('section', '');
    }

    /**
     * @return \ProgramCms\ConfigBundle\Model\Structure\Element\Iterator\Tab
     */
    public function getTabs(): \ProgramCms\ConfigBundle\Model\Structure\Element\Iterator\Tab
    {
        return $this->configSerializer->getTabs();
    }

    /**
     * @param Section $section
     * @return string
     */
    public function getSectionUrl(Section $section): string
    {
        return $this->getUrl('config_systemconfig_edit', ['section' => $section->getId()]);
    }

    /**
     * @param Section $section
     * @return bool
     */
    public function isSectionActive(Section $section): bool
    {
        return $section->getId() == $this->_currentSectionId;
    }

    /**
     * @param Tab $tab
     * @return bool
     */
    public function isTabActive(Tab $tab): bool
    {
        $isOpen = false;
        foreach($tab->getChildren() as $section) {
            if($this->isSectionActive($section)) {
                $isOpen = true;
            }
        }
        return $isOpen;
    }
}