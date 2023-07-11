<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

/**
 * Class State
 * @package ProgramCms\CoreBundle\App
 */
class State
{
    /**
     * Area code
     *
     * @var string
     */
    protected string $_areaCode;

    public function __construct()
    {
        $this->_areaCode = "";
    }

    /**
     * Set Area Code
     * @param $areaCode
     * @return $this
     */
    public function setAreaCode($areaCode): static
    {
        $this->_areaCode = $areaCode;
        return $this;
    }

    /**
     * Get Area Code
     * @return string
     */
    public function getAreaCode(): string
    {
        return $this->_areaCode;
    }
}