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
    /**
     * @var \ProgramCms\ConfigBundle\Model\ConfigSerializer
     */
    protected \ProgramCms\ConfigBundle\Model\ConfigSerializer $configSerializer;
    /**
     * @var \ProgramCms\RouterBundle\Service\Request
     */
    protected \ProgramCms\RouterBundle\Service\Request $request;
    /**
     * @var \ProgramCms\CoreBundle\Model\ObjectManager
     */
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
        $this->_initConfigSerializer();
    }

    /**
     * @throws \ReflectionException
     */
    private function _initConfigSerializer()
    {
        if ($this->request->getParam('sectionId')) {
            $this->configSerializer->setSectionId($this->request->getParam('sectionId'));
        }

        $this->configSerializer->parseConfig();
    }

    /**
     * @return array
     */
    public function getTabs(): array
    {
        return $this->configSerializer->getConfigNavigation();
    }

    /**
     * @throws \Exception
     */
    protected function _prepareLayout()
    {
        $layout = $this->getLayout();
        $currentSectionGroups = $this->configSerializer->getCurrenSectionGroups();
        foreach ($currentSectionGroups as $groupId => $group) {
            $collapser = $layout->createBlock(\ProgramCms\UiBundle\Block\Collapser\Collapser::class, 'collapse-' . $groupId);
            $collapser->setData("label", $group['label']);
            $collapser->setName('collapse-' . $groupId);
            $collapser->setTemplateContext($collapser);

            $form = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Form::class, 'form-' . $groupId);
            $form->setTemplateContext($form);
            // Field sets
            $fieldSets = [
                "fieldSets" => [
                    "fieldset1" => [
                        "fields" => []
                    ]
                ]
            ];
            // Add fields to form
            foreach ($group['fields'] as $fieldId => $field) {
                $fieldSets['fieldSets']['fieldset1']['fields'][$groupId . '/' . $fieldId] = $field;
            }

            $form->setData($fieldSets);
            $collapser->setChild('form-' . $groupId, $form);
            $this->setChild('collapse-' . $groupId, $collapser);
        }
    }

    /**
     * Get current section id
     * @return string
     */
    public function getSectionId(): string
    {
        return $this->configSerializer->getSectionId();
    }
}