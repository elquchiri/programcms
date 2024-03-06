<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App\Config;

/**
 * Class ConfigSourceAggregated
 * @package ProgramCms\CoreBundle\App\Config
 */
class ConfigSourceAggregated implements ConfigSourceInterface
{
    /**
     * @var array
     */
    private array $sources;

    /**
     * ConfigSourceAggregated constructor.
     * @param array $sources
     */
    public function __construct(
        array $sources = []
    )
    {
        $this->sources = $sources;
        uasort($this->sources, function ($firstItem, $secondItem) {
            return $firstItem['sortOrder'] <=> $secondItem['sortOrder'];
        });
    }

    /**
     * @param string $path
     * @return array|mixed
     */
    public function get($path = '')
    {
        $data = [];
        foreach ($this->sources as $sourceConfig) {
            /** @var ConfigSourceInterface $source */
            $source = $sourceConfig['source'];
            $configData = $source->get($path);
            if (!is_array($configData)) {
                $data = $configData;
            } elseif (!empty($configData)) {
                $data = array_replace_recursive(is_array($data) ? $data : [], $configData);
            }
        }
        return $data;
    }
}