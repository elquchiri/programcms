<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Model\Attribute\Data;

/**
 * Class AbstractData
 * @package ProgramCms\EavBundle\Model\Attribute\Data
 */
abstract class AbstractData
{
    /**
     * @param string $format
     * @return mixed
     */
    abstract public function outputValue($format = 'text');
}