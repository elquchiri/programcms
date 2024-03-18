<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View;

use ProgramCms\CoreBundle\App\AreaInterface;
use ProgramCms\CoreBundle\App\AreaList;
use ProgramCms\CoreBundle\App\State;
use ReflectionException;

/**
 * Class DesignLoader
 * @package ProgramCms\CoreBundle\View
 */
class DesignLoader
{
    /**
     * @var AreaList
     */
    protected AreaList $areaList;

    /**
     * @var State
     */
    protected State $state;

    /**
     * DesignLoader constructor.
     * @param AreaList $areaList
     * @param State $state
     */
    public function __construct(
        AreaList $areaList,
        State $state,
    )
    {
        $this->areaList = $areaList;
        $this->state = $state;
    }

    /**
     * @throws ReflectionException
     */
    public function load()
    {
        $area = $this->areaList->getArea(
            $this->state->getAreaCode()
        );
        $area->load(AreaInterface::PART_DESIGN);
    }
}