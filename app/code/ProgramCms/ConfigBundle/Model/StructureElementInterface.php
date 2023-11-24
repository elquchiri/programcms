<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model;

/**
 * Interface StructureElementInterface
 * @package ProgramCms\ConfigBundle\Model
 */
interface StructureElementInterface extends \ProgramCms\ConfigBundle\Model\Structure\ElementInterface
{
    /**
     * Retrieve element config path
     */
    public function getPath($fieldPrefix = '');
}