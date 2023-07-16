<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Block;

use ReflectionException;

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
     * @var \ProgramCms\RouterBundle\Service\Url
     */
    private \ProgramCms\RouterBundle\Service\Url $url;

    /**
     * Configuration constructor.
     * @param \ProgramCms\CoreBundle\View\Element\Template\Context $context
     * @param \ProgramCms\ConfigBundle\Model\ConfigSerializer $configSerializer
     * @param array $data
     * @throws ReflectionException
     */
    public function __construct(
        \ProgramCms\CoreBundle\View\Element\Template\Context $context,
        \ProgramCms\ConfigBundle\Model\ConfigSerializer $configSerializer,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->configSerializer = $configSerializer;
        $this->request = $context->getRequest();
        $this->url = $context->getUrl();
        // Init Config Serializer
        $this->_initConfigSerializer();
    }

    /**
     * @throws ReflectionException
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
        $form = $layout->createBlock(
            \ProgramCms\UiBundle\Block\Form\Form::class,
            'form',
            [
                'buttons' => [
                    [
                        'buttonType' => 'save',
                        'buttonTarget' => 'form',
                        'buttonAction' => 'config_systemconfig_save',
                        'label' => 'Save Config'
                    ]
                ]
            ]);
        $form->setLayout($layout);
        foreach ($currentSectionGroups as $groupId => $group) {
            $collapser = $layout->createBlock(\ProgramCms\UiBundle\Block\Collapser\Collapser::class, 'collapse-' . $groupId);
            $collapser->setData("label", $group['label']);

            // Fields
            $fields = ['fields' => []];
            // Add fields to form
            foreach ($group['fields'] as $fieldId => $field) {
                $fields['fields'][$groupId . '/' . $fieldId] = $field;
            }
            $fieldset = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fieldset::class, 'fieldset-' . $groupId, $fields);
            $fieldset->setLayout($layout);
            $collapser->setChild('fieldset-' . $groupId, $fieldset);
            $form->setChild('collapse-' . $groupId, $collapser);
        }
        $hiddenInput = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Hidden::class, 'section_id', [
            'value' => $this->configSerializer->getSectionId()
        ]);
        $form->setChild('section_id', $hiddenInput);

        $this->setChild('form', $form);
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