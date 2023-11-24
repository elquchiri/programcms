<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model;


use ProgramCms\ConfigBundle\Model\Structure\Element\Field;
use ProgramCms\CoreBundle\Model\DataObject;

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
    protected Loader $loader;
    protected \ProgramCms\ConfigBundle\App\Config $config;

    public function __construct(
        \ProgramCms\ConfigBundle\Model\ConfigSerializer $configSerializer,
        \ProgramCms\ConfigBundle\Model\Loader $loader,
        \ProgramCms\ConfigBundle\App\Config $config
    )
    {
        $this->configSerializer = $configSerializer;
        $this->loader = $loader;
        $this->config = $config;
    }

    public function save()
    {
        $this->initScope();
        $groups = $this->getData('groups');
        $sectionId = $this->getData('section');
        $oldConfig = $this->_getConfig(true);

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
     */
    protected function _processGroup($groupId, $groupData, $groups, $sectionId, $oldConfig)
    {
        $groupPath = $sectionId . '/' . $groupId;

        if (isset($groupData['fields'])) {
            $group = $this->configSerializer->getElement($groupPath);
            $fieldsetData = [];
            foreach ($groupData['fields'] as $fieldId => $fieldData) {
                $fieldsetData[$fieldId] = $fieldData['value'] ?? null;
            }

            foreach ($groupData['fields'] as $fieldId => $fieldData) {
                $field = $this->getField($sectionId, $groupId, $fieldId);

                if (!isset($fieldData['value'])) {
                    $fieldData['value'] = null;
                }

                if ($field->getType() == 'multiline' && is_array($fieldData['value'])) {
                    $fieldData['value'] = trim(implode(PHP_EOL, $fieldData['value']));
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
    protected function _getConfig($full = true)
    {
        return $this->loader->getConfigByPath(
            $this->getSection(),
            $this->getScopeType(),
            $this->getScopeCode(),
            $full
        );
    }

    private function initScope()
    {
        if($this->getSection() === null) {
            $this->setSection('');
        }

        $scopeType = '';
        $scopeIdentifier = null;
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
                $scopeType = \ProgramCms\ConfigBundle\App\ScopeInterface::SCOPE_DEFAULT;
                $scopeIdentifier = null;
                break;
        }
        $this->setScopeType($scopeType);
        $this->setScopeCode($scopeIdentifier ?: 0);
    }
}