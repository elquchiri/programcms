<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

/**
 * Class AreaList
 * @package ProgramCms\CoreBundle\App
 */
class AreaList
{
    /**
     * @var array
     */
    protected array $_areas = [];

    /**
     * AreaList constructor.
     * @param array $areas
     */
    public function __construct(array $areas = [])
    {
        $this->_areas = array_merge($this->_areas, $areas);
    }

    /**
     * Get Area code
     * @param $name
     * @return string
     */
    public function getCodeByFrontName($name): string
    {
        foreach($this->_areas as $areaCode => $area) {
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
        return array_keys($this->_areas);
    }

    /**
     * @return array
     */
    public function getAreas(): array
    {
        return $this->_areas;
    }
}