<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Component;

use Exception;
use ProgramCms\ConfigBundle\Repository\CoreConfigDataRepository;
use ProgramCms\CoreBundle\App\Config;
use ProgramCms\ConfigBundle\Model\ConfigSerializer;
use ProgramCms\ConfigBundle\Model\Structure\Element\Field;
use ProgramCms\ConfigBundle\Model\Structure\Element\Group;
use ProgramCms\ConfigBundle\Model\Structure\Element\Section;
use ProgramCms\UiBundle\Component\Form\Form;
use ProgramCms\UiBundle\View\Element\Context;

/**
 * Class Configuration
 * @package ProgramCms\ConfigBundle\Block
 */
class ConfigForm extends Form
{
    const SCOPE_DEFAULT = 'default';

    const SCOPE_WEBSITE = 'website';

    const SCOPE_WEBSITE_VIEW = 'website_view';

    /**
     * @var ConfigSerializer
     */
    protected ConfigSerializer $configSerializer;

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
     * @var CoreConfigDataRepository
     */
    protected CoreConfigDataRepository $configDataRepository;

    /**
     * Configuration Form Component constructor.
     * @param Context $context
     * @param ConfigSerializer $configSerializer
     * @param Config $config
     * @param CoreConfigDataRepository $configDataRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        ConfigSerializer $configSerializer,
        Config $config,
        CoreConfigDataRepository $configDataRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->configSerializer = $configSerializer;
        $this->config = $config;

        $this->_scopeLabels = [
            self::SCOPE_DEFAULT => $this->trans('[GLOBAL]'),
            self::SCOPE_WEBSITE => $this->trans('[WEBSITE]'),
            self::SCOPE_WEBSITE_VIEW => $this->trans('[WEBSITE VIEW]'),
        ];
        $this->configDataRepository = $configDataRepository;
    }

    /**
     * @throws Exception
     */
    public function prepare()
    {
        parent::prepare();

        $layout = $this->getLayout();
        $section = $this->configSerializer->getElement($this->getSectionId());
        if ($section && $section->isVisible()) {
            foreach ($section->getChildren() as $group) {
                $this->_initGroup($group, $section, $this);
            }
        }

        foreach($this->_fieldSets as $fieldsetName => $fieldset) {
            $fieldsetComponent = $this->getContext()
                ->getUiComponentFactory()
                ->create(
                    'fieldset',
                    $fieldsetName,
                    ['label' => $fieldset['label'], 'collapse' => true],
                    $layout
                );

            if(isset($fieldset['fields'])) {
                foreach($fieldset['fields'] as $childElementName => $childElement) {
                    $fieldComponent = $this->getContext()
                        ->getUiComponentFactory()
                        ->create(
                            'field',
                            $childElement['name'],
                            $childElement,
                            $layout
                        );
                    $fieldsetComponent->setChild($childElementName, $fieldComponent);
                }
            }

            $this->setChild($fieldsetName, $fieldsetComponent);
        }

        /**
         * Add hidden inputs for website and websiteView Scopes
         */
        $request = $this->getRequest();

        // Add hidden input to send sectionId parameter
        $hiddenSectionInput = $layout->createBlock(\ProgramCms\UiBundle\Component\Form\Element\Hidden::class, 'section', [
            'value' => $this->getSectionId()
        ]);
        $hiddenWebsiteScope = $layout->createBlock(\ProgramCms\UiBundle\Component\Form\Element\Hidden::class, 'website', [
            'value' => $request->getParam('website')
        ]);
        $hiddenWebsiteViewScope = $layout->createBlock(\ProgramCms\UiBundle\Component\Form\Element\Hidden::class, 'website_view', [
            'value' => $request->getParam('website_view')
        ]);
        $this->setChild('section', $hiddenSectionInput);
        $this->setChild('website', $hiddenWebsiteScope);
        $this->setChild('website_view', $hiddenWebsiteViewScope);
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

        // Get config value from fallback mechanism
        $value = $this->config->getValue(
            $field->getPath(),
            $this->getScope(),
            $this->getScopeCode());

        // Get dynamic config value to check inherit
        $realValue = $this->configDataRepository->getByPath(
            $field->getPath(),
            $this->getScope(),
            $this->getScopeCode()
        );

        $inherit = !(isset($realValue) && !empty($realValue));

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
        $fieldId = array_pop($part);
        $groupName = implode('][groups][', $part);
        return 'groups[' . $groupName . '][fields][' . $fieldPrefix . $fieldId . '][value]';
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
    public function getSectionId(): string
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

    /**
     * @param Field $field
     * @return false
     */
    public function isReadOnly(Field $field)
    {
        return false;
    }
}