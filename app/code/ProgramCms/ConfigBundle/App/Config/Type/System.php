<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\App\Config\Type;

use ProgramCms\ConfigBundle\App\Config\Type\System\Reader;
use ProgramCms\CoreBundle\App\ScopeInterface;
use ProgramCms\CoreBundle\App\Config\ConfigTypeInterface;
use ProgramCms\CoreBundle\Model\DataObject;

/**
 * Class System
 * @package ProgramCms\ConfigBundle\App\Config\Type
 */
class System implements ConfigTypeInterface
{
    /**
     * Config Type
     */
    const CONFIG_TYPE = 'system';

    /**
     * @var Reader
     */
    protected Reader $reader;

    /**
     * @var array
     */
    private array $data = [];

    /**
     * System constructor.
     * @param Reader $reader
     */
    public function __construct(
        Reader $reader
    )
    {
        $this->reader = $reader;
    }

    /**
     * @param string $path
     * @return array|void
     */
    public function get($path = '')
    {
        if ($path === '') {
            $this->data = array_replace_recursive($this->loadAllData(), $this->data);

            return $this->data;
        }

        return $this->getWithParts($path);
    }

    /**
     * @param $path
     * @return mixed|null
     */
    private function getWithParts($path)
    {
        $pathParts = explode('/', $path);
        $scopeType = array_shift($pathParts);

        if ($scopeType === ScopeInterface::SCOPE_DEFAULT) {
            if (!isset($this->data[$scopeType])) {
                $this->data = array_replace_recursive($this->loadDefaultScopeData($scopeType), $this->data);
            }

            return $this->getDataByPathParts($this->data[$scopeType], $pathParts);
        }

        $scopeId = array_shift($pathParts);

        if (!isset($this->data[$scopeType][$scopeId])) {
            $scopeData = $this->loadScopeData($scopeType, $scopeId);

            if (!isset($this->data[$scopeType][$scopeId])) {
                $this->data = array_replace_recursive($scopeData, $this->data);
            }
        }

        return isset($this->data[$scopeType][$scopeId])
            ? $this->getDataByPathParts($this->data[$scopeType][$scopeId], $pathParts)
            : null;
    }

    /**
     * @param $scopeType
     * @return array
     */
    private function loadDefaultScopeData($scopeType)
    {
        return $this->loadAllData();
    }

    /**
     * @param $data
     * @param $pathParts
     * @return mixed|null
     */
    private function getDataByPathParts($data, $pathParts)
    {
        foreach ($pathParts as $key) {
            if ((array)$data === $data && isset($data[$key])) {
                $data = $data[$key];
            } elseif ($data instanceof DataObject) {
                $data = $data->getDataByKey($key);
            } else {
                return null;
            }
        }

        return $data;
    }

    /**
     * @param $scopeType
     * @param $scopeId
     * @return array
     */
    private function loadScopeData($scopeType, $scopeId)
    {
        return $this->loadAllData();
    }

    /**
     * @return array
     */
    private function loadAllData()
    {
        return $this->readData();
    }

    /**
     * @return array
     */
    private function readData()
    {
        return $this->reader->read();
    }
}