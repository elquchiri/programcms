<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Block;

/**
 * Class Configuration
 * @package ProgramCms\ConfigBundle\Block
 */
class Configuration extends \ProgramCms\CoreBundle\View\Element\Template
{

    protected \ProgramCms\ConfigBundle\Model\ConfigSerializer $configSerializer;
    protected \ProgramCms\RouterBundle\Service\Request $request;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\ConfigBundle\Model\ConfigSerializer $configSerializer,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->configSerializer = $configSerializer;
        $this->request = $context->getRequest();
        $this->initConfigSerializer();
    }

    private function initConfigSerializer()
    {
        if($this->request->getParam('sectionId')) {
            $this->configSerializer->setSectionId($this->request->getParam('sectionId'));
        }

        $this->configSerializer->parseConfig();
    }

    public function getTabs()
    {
        return $this->configSerializer->getConfigNavigation();
    }

    public function getCurrentSectionGroups()
    {
        return $this->configSerializer->getCurrenSectionGroups();
    }

    public function getSectionId()
    {
        return $this->configSerializer->getSectionId();
    }
}