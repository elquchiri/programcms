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
    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;

    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\ConfigBundle\Model\ConfigSerializer $configSerializer,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->configSerializer = $configSerializer;
        $this->request = $context->getRequest();
        $this->objectManager = $objectManager;
        // Init Config Serializer
        $this->initConfigSerializer();
    }

    /**
     * @throws \ReflectionException
     */
    private function initConfigSerializer()
    {
        if($this->request->getParam('sectionId')) {
            $this->configSerializer->setSectionId($this->request->getParam('sectionId'));
        }

        $this->configSerializer->parseConfig();
    }

    /**
     * @return mixed
     */
    public function getTabs()
    {
        return $this->configSerializer->getConfigNavigation();
    }

    public function getCurrentSectionGroups()
    {
        $currentSectionGroups = $this->configSerializer->getCurrenSectionGroups();
        foreach($currentSectionGroups as $groupId => $group) {
            $collapser = $this->objectManager->create(\ProgramCms\UiBundle\Block\Collapser\Collapser::class);
            $collapser->setData("label", $group['label']);
            $form = $this->objectManager->create(\ProgramCms\UiBundle\Block\Form\Form::class);
        }
        return $currentSectionGroups;
    }

    /**
     * @return string
     */
    public function getSectionId(): string
    {
        return $this->configSerializer->getSectionId();
    }
}