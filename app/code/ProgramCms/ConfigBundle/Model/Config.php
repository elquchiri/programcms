<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model;

use ProgramCms\ConfigBundle\Model\Attribute\Backend\AbstractBackend;
use ProgramCms\ConfigBundle\Model\Structure\Element\Field;
use ProgramCms\CoreBundle\App\ScopeInterface;
use ProgramCms\CoreBundle\Model\DataObject;
use ProgramCms\CoreBundle\Model\ObjectManager;

/**
 * Class Config
 * @package ProgramCms\ConfigBundle\Model
 */
class Config extends DataObject
{
    /**
     * @var ConfigSerializer
     */
    protected ConfigSerializer $configSerializer;

    /**
     * @var Loader
     */
    protected Loader $loader;

    /**
     * @var \ProgramCms\ConfigBundle\App\Config
     */
    protected \ProgramCms\ConfigBundle\App\Config $config;

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * Config constructor.
     * @param ConfigSerializer $configSerializer
     * @param Loader $loader
     * @param \ProgramCms\ConfigBundle\App\Config $config
     * @param ObjectManager $objectManager
     * @param array $data
     */
    public function __construct(
        ConfigSerializer $configSerializer,
        Loader $loader,
        \ProgramCms\ConfigBundle\App\Config $config,
        ObjectManager $objectManager,
        array $data = []
    )
    {
        parent::__construct($data);
        $this->configSerializer = $configSerializer;
        $this->loader = $loader;
        $this->config = $config;
        $this->objectManager = $objectManager;
    }

    /**
     * Save Config
     */
    public function save()
    {
        $this->initScope();
        $groups = $this->getData('groups');
        $sectionId = $this->getData('section');
        $oldConfig = $this->_getConfig();

        foreach($groups as $groupId => $groupData) {
            $this->_processGroup($groupId, $groupData, $groups, $sectionId, $oldConfig);
        }
    }

    /**
     * @param $groupId
     * @param $groupData
     * @param $groups
     * @param $sectionId
     * @param $oldConfig
     * @throws \ReflectionException
     */
    protected function _processGroup($groupId, $groupData, $groups, $sectionId, $oldConfig)
    {
        if (isset($groupData['fields'])) {
            foreach ($groupData['fields'] as $fieldId => $fieldData) {
                $field = $this->getField($sectionId, $groupId, $fieldId);

                if (!isset($fieldData['value'])) {
                    $fieldData['value'] = null;
                }

                if ($field->getType() == 'multiselect' && is_array($fieldData['value'])) {
                    $fieldData['value'] = trim(implode(PHP_EOL, $fieldData['value']));
                }

                if($field->hasBackendModel()) {
                    $backendModelClass = $field->getBackendModel();
                    /** @var AbstractBackend $backendModel */
                    $backendModel = $this->objectManager->create($backendModelClass);
                    $backendModel->beforeSave($fieldData);
                }

                $path = $this->getFieldPath($sectionId, $groupId, $fieldId);

                $inherit = !empty($fieldData['inherit']);

                if(!$inherit) {
                    // Save Field Config
                    $this->config->setConfigValue(
                        $path,
                        $fieldData['value'],
                        $this->getScopeType(),
                        $this->getScopeCode()
                    );
                }else{
                    // Delete Field Config
                    if (isset($oldConfig[$path])) {
                        $this->config->deleteConfigValue($oldConfig[$path]['config_id']);
                    }
                }
            }
        }
    }

    /**
     * @param string $sectionId
     * @param string $groupId
     * @param string $fieldId
     * @return Field
     */
    private function getField(string $sectionId, string $groupId, string $fieldId): Field
    {
        $fieldPath = $this->getFieldPath($sectionId, $groupId, $fieldId);
        return $this->configSerializer->getElement($fieldPath);
    }

    /**
     * @param $sectionId
     * @param string $groupId
     * @param string $fieldId
     * @return string
     */
    private function getFieldPath($sectionId, string $groupId, string $fieldId)
    {
        $group = $this->configSerializer->getElement($sectionId . '/' . $groupId);
        return $group->getPath() . '/' . $fieldId;
    }

    /**
     * @param bool $full
     * @return array
     */
    protected function _getConfig(bool $full = true): array
    {
        return $this->loader->getConfigByPath(
            $this->getSection(),
            $this->getScopeType(),
            $this->getScopeCode(),
            $full
        );
    }

    /**
     * Init Scope
     */
    private function initScope()
    {
        if($this->getSection() === null) {
            $this->setSection('');
        }

        switch (true) {
            case $this->getWebsiteView():
                $scopeType = \ProgramCms\WebsiteBundle\Model\ScopeInterface::SCOPE_WEBSITE_VIEW;
                $scopeIdentifier = $this->getWebsiteView();
                break;
            case $this->getWebsite():
                $scopeType = \ProgramCms\WebsiteBundle\Model\ScopeInterface::SCOPE_WEBSITE;
                $scopeIdentifier = $this->getWebsite();
                break;
            default:
                $scopeType = ScopeInterface::SCOPE_DEFAULT;
                $scopeIdentifier = null;
                break;
        }
        $this->setScopeType($scopeType);
        $this->setScopeCode($scopeIdentifier ?: 0);
    }
}