<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\App\Config\Source;

use Doctrine\DBAL\Exception\TableNotFoundException;
use ProgramCms\ConfigBundle\Entity\CoreConfigData;
use ProgramCms\CoreBundle\App\Config\ConfigSourceInterface;
use ProgramCms\ConfigBundle\Model\Collection\Collection;
use ProgramCms\CoreBundle\App\Config\Scope\Converter;
use ProgramCms\CoreBundle\App\ScopeConfigInterface;
use ProgramCms\CoreBundle\App\Config\ScopeCodeResolver;
use ProgramCms\CoreBundle\Model\DataObject;

/**
 * Class RuntimeConfigSource
 * @package ProgramCms\ConfigBundle\App\Config\Source
 */
class RuntimeConfigSource implements ConfigSourceInterface
{
    /**
     * @var Collection
     */
    protected Collection $collection;

    /**
     * @var ScopeCodeResolver
     */
    protected ScopeCodeResolver $scopeCodeResolver;

    /**
     * @var Converter
     */
    protected Converter $converter;

    /**
     * RuntimeConfigSource constructor.
     * @param Collection $collection
     * @param ScopeCodeResolver $scopeCodeResolver
     * @param Converter $converter
     */
    public function __construct(
        Collection $collection,
        ScopeCodeResolver $scopeCodeResolver,
        Converter $converter
    )
    {
        $this->collection = $collection;
        $this->scopeCodeResolver = $scopeCodeResolver;
        $this->converter = $converter;
    }

    /**
     * @param string $path
     * @return array|mixed|null
     */
    public function get($path = '')
    {
        $data = new DataObject($this->loadConfig());

        return $data->getData($path) !== null ? $data->getData($path) : null;
    }

    /**
     * @return array
     */
    private function loadConfig()
    {
        try {
            $collection = $this->collection->getData();
        } catch (\DomainException $e) {
            $collection = [];
        } catch (TableNotFoundException $exception) {
            // Database is empty or not installed
            $collection = [];
        }
        $config = [];
        /** @var CoreConfigData $item */
        foreach ($collection as $item) {
            if ($item->getScope() === ScopeConfigInterface::SCOPE_TYPE_DEFAULT) {
                $config[$item->getScope()][$item->getPath()] = $item->getValue();
            } else {
                $code = $this->scopeCodeResolver->resolve($item->getScope(), $item->getScopeId());
                $config[$item->getScope()][$code][$item->getPath()] = $item->getValue();
            }
        }
        foreach ($config as $scope => &$item) {
            if ($scope === ScopeConfigInterface::SCOPE_TYPE_DEFAULT) {
                $item = $this->converter->convert($item);
            } else {
                foreach ($item as &$scopeItems) {
                    $scopeItems = $this->converter->convert($scopeItems);
                }
            }
        }
        return $config;
    }
}