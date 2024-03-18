<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ReflectionException;

/**
 * Class AreaList
 * @package ProgramCms\CoreBundle\App
 */
class AreaList
{
    /**
     * @var array
     */
    protected array $areas = [];

    /**
     * @var array
     */
    protected array $areaInstances = [];

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * AreaList constructor.
     * @param ObjectManager $objectManager
     * @param array $areas
     */
    public function __construct(
        ObjectManager $objectManager,
        array $areas = []
    )
    {
        $this->areas = array_merge($this->areas, $areas);
        $this->objectManager = $objectManager;
    }

    /**
     * Get Area code
     * @param $name
     * @return string
     */
    public function getCodeByFrontName($name): string
    {
        foreach($this->areas as $areaCode => $area) {
            if (isset($area['frontName']) && $area['frontName'] === $name) {
                return $areaCode;
            }
        }

        // TODO: Define a default area later if necessary
        // return 'default';
        return 'frontend';
    }

    /**
     * Retrieve area codes
     *
     * @return string[]
     */
    public function getCodes(): array
    {
        return array_keys($this->areas);
    }

    /**
     * @param string $code
     * @return AreaInterface
     * @throws ReflectionException
     */
    public function getArea(string $code): AreaInterface
    {
        if (!isset($this->areaInstances[$code])) {
            $this->areaInstances[$code] = $this->objectManager->create(
                AreaInterface::class,
                ['areaCode' => $code]
            );
        }
        return $this->areaInstances[$code];
    }

    /**
     * @return array
     */
    public function getAreas(): array
    {
        return $this->areas;
    }
}