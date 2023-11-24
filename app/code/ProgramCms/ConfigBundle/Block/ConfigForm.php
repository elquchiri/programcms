<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Block;

use Exception;
use JetBrains\PhpStorm\Pure;
use ProgramCms\ConfigBundle\App\Config;
use ProgramCms\ConfigBundle\Model\ConfigSerializer;
use ProgramCms\ConfigBundle\Model\Structure\Element\Field;
use ProgramCms\ConfigBundle\Model\Structure\Element\Group;
use ProgramCms\ConfigBundle\Model\Structure\Element\Section;
use ProgramCms\CoreBundle\View\Element\Template\Context;
use ReflectionException;

/**
 * Class Configuration
 * @package ProgramCms\ConfigBundle\Block
 */
class ConfigForm extends \ProgramCms\CoreBundle\View\Element\Template
{
    const SCOPE_DEFAULT = 'default';

    const SCOPE_WEBSITE = 'website';

    const SCOPE_WEBSITE_VIEW = 'website_view';

    /**
     * @var ConfigSerializer
     */
    protected ConfigSerializer $configSerializer;
    /**
     * @var \ProgramCms\RouterBundle\Service\Request
     */
    protected \ProgramCms\RouterBundle\Service\Request $request;
    /**
     * @var array
     */
    protected array $_fieldSets = [];
    /**
     * @var Config
     */
    protected Config $config;
    /**
     * @var array
     */
    protected array $_scopeLabels;

    /**
     * Configuration constructor.
     * @param Context $context
     * @param ConfigSerializer $configSerializer
     * @param array $data
     * @throws ReflectionException
     */
    public function __construct(
        Context $context,
        ConfigSerializer $configSerializer,
        \ProgramCms\ConfigBundle\App\Config $config,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->configSerializer = $configSerializer;
        $this->request = $context->getRequest();
        $this->config = $config;

        $this->_scopeLabels = [
            self::SCOPE_DEFAULT => $this->trans('[GLOBAL]'),
            self::SCOPE_WEBSITE => $this->trans('[WEBSITE]'),
            self::SCOPE_WEBSITE_VIEW => $this->trans('[WEBSITE VIEW]'),
        ];
    }

    /**
     * @throws Exception
     */
    protected function _prepareLayout(): static
    {
        $layout = $this->getLayout();
        $form = $layout->createBlock(
            \ProgramCms\UiBundle\Block\Form\Form::class,
            'form'
        );
        $section = $this->configSerializer->getElement($this->getSectionId());
        if ($section && $section->isVisible()) {
            foreach ($section->getChildren() as $group) {
                $this->_initGroup($group, $section, $form);
            }
        }

        $form->setAttribute('buttons', [
            [
                'buttonType' => 'save',
                'buttonTarget' => 'form',
                'buttonAction' => 'config_systemconfig_save',
                'label' => 'Save Config'
            ]
        ]);

        $form->setAttribute('fieldsets', $this->_fieldSets);

        $form->setLayout($layout);

        /**
         * Add hidden inputs for website and websiteView Scopes
         */
        $request = $this->getRequest();

        // Add hidden input to send sectionId parameter
        $hiddenSectionInput = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Hidden::class, 'section', [
            'value' => $this->getSectionId()
        ]);
        $hiddenWebsiteScope = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Hidden::class, 'website', [
            'value' => $request->getParam('website')
        ]);
        $hiddenWebsiteViewScope = $layout->createBlock(\ProgramCms\UiBundle\Block\Form\Fields\Hidden::class, 'website_view', [
            'value' => $request->getParam('website_view')
        ]);
        $form->setChild('section', $hiddenSectionInput);
        $form->setChild('website', $hiddenWebsiteScope);
        $form->setChild('website_view', $hiddenWebsiteViewScope);

        return $this->setChild('form', $form);
    }

    /**
     * @param Group $group
     * @param Section $section
     * @param $form
     */
    protected function _initGroup(
        Group $group,
        Section $section,
        $form
    )
    {
        $fieldSet = ['label' => $group->getLabel()];
        $this->_initFields($fieldSet, $group, $section, $form);
        $this->_fieldSets['fieldset-' . $group->getId()] = $fieldSet;
    }

    /**
     * @param $fieldSet
     * @param Group $group
     * @param Section $section
     * @param $form
     * @return $this
     */
    protected function _initFields(
        &$fieldSet,
        Group $group,
        Section $section,
        $form
    )
    {
        foreach ($group->getChildren() as $element) {
            if($element instanceof Group) {
                $this->_initGroup($element, $section, $form);
            }else {
                $this->_initElement($element, $group, $fieldSet, $section);
            }
        }
        return $this;
    }

    /**
     * @param Field $field
     * @param Group $group
     * @param $fieldSet
     * @param Section $section
     */
    protected function _initElement(
        Field $field,
        Group $group,
        &$fieldSet,
        Section $section
    )
    {
        $fieldName = $this->_generateElementName($field);
        $fieldId = $this->_generateElementId($field);
        $isReadOnly = $this->isReadOnly($field);

        $value = $this->config->getConfigValue(
            $field->getPath(),
            $this->getScope(),
            $this->getScopeCode());

        $inherit = !(isset($value) && !empty($value));

        $fieldSet['fields'][$group->getId() . '/' . $field->getId()] = [
            'name' => $fieldName,
            'id' => $fieldId,
            'label' => $field->getLabel(),
            'elementType' => 'field',
            'type' => $field->getType(),
            'inherit' => $inherit,
            'helpMessage' => $field->getHelpMessage(),
            'sourceModel' => $field->getSourceModel(),
            'scope' => $this->getScope(),
            'scopeLabel' => $this->getScopeLabel($field),
            'canUseDefaultValue' => $this->canUseDefaultValue($field->showInDefault()),
            'canUseWebsiteValue' => $this->canUseWebsiteValue($field->showInWebsite()),
            'canRestoreToDefault' => $this->isCanRestoreToDefault($field->canRestore()),
            'disabled' => $isReadOnly,
            'is_disable_inheritance' => $isReadOnly,
            'value' => $value
        ];
    }

    /**
     * @param Field $field
     * @param string $fieldPrefix
     * @param string $separator
     * @return string
     */
    protected function _generateElementName(Field $field, $fieldPrefix = '', $separator = '/')
    {
        $part = explode($separator, $field->getPath());
        array_shift($part);
        //shift section name
        $fieldId = array_pop($part);
        //shift filed id
        $groupName = implode('][groups][', $part);
        $name = 'groups[' . $groupName . '][fields][' . $fieldPrefix . $fieldId . '][value]';
        return $name;
    }

    /**
     * @param Field $field
     * @return array|string
     */
    protected function _generateElementId(Field $field): array|string
    {
        return str_replace('/', '_', $field->getPath());
    }

    /**
     * Get Scope Label
     * @param Field $field
     * @return string
     */
    public function getScopeLabel(Field $field): string
    {
        if($field->showInWebsiteView()) {
            return $this->_scopeLabels[self::SCOPE_WEBSITE_VIEW];
        } elseif($field->showInWebsite()) {
            return $this->_scopeLabels[self::SCOPE_WEBSITE];
        }
        return $this->_scopeLabels[self::SCOPE_DEFAULT];
    }

    /**
     * Get current section id
     * @return string
     */
    #[Pure] public function getSectionId(): string
    {
        return $this->getRequest()->getParam('section');
    }

    /**
     * Get Current Scope
     * @return string
     */
    public function getScope(): string
    {
        if ($this->getWebsiteViewCode()) {
            return self::SCOPE_WEBSITE_VIEW;
        } else if ($this->getWebsiteCode()) {
            return self::SCOPE_WEBSITE;
        }
        return self::SCOPE_DEFAULT;
    }

    /**
     * @return array|mixed|string
     */
    public function getScopeCode()
    {
        $scopeCode = $this->hasData('scope_code') ? $this->getData('scope_code') : null;
        if ($scopeCode === null) {
            if ($this->getWebsiteViewCode()) {
                $scopeCode = $this->getWebsiteViewCode();
            } elseif ($this->getWebsiteCode()) {
                $scopeCode = $this->getWebsiteCode();
            } else {
                $scopeCode = '';
            }
            $this->setData('scope_data', $scopeCode);
        }

        return $scopeCode;
    }

    /**
     * @return string
     */
    public function getWebsiteCode(): string
    {
        return $this->getRequest()->getParam('website');
    }

    /**
     * @return string
     */
    public function getWebsiteViewCode(): string
    {
        return $this->getRequest()->getParam('website_view');
    }

    /**
     * @param $fieldValue
     * @return bool
     */
    public function canUseDefaultValue($fieldValue): bool
    {
        if ($this->getScope() == self::SCOPE_WEBSITE_VIEW && $fieldValue) {
            return true;
        }
        if ($this->getScope() == self::SCOPE_WEBSITE && $fieldValue) {
            return true;
        }
        return false;
    }

    /**
     * @param $fieldValue
     * @return bool
     */
    public function canUseWebsiteValue($fieldValue)
    {
        if ($this->getScope() == self::SCOPE_WEBSITE_VIEW && $fieldValue) {
            return true;
        }
        return false;
    }

    /**
     * @param $fieldValue
     * @return bool
     */
    public function isCanRestoreToDefault($fieldValue)
    {
        if ($this->getScope() == self::SCOPE_DEFAULT && $fieldValue) {
            return true;
        }
        return false;
    }

    public function isReadOnly(Field $field)
    {
        return false;
    }
}