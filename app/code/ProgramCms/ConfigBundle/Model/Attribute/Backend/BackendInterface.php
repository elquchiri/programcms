<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\Model\Attribute\Backend;

/**
 * Interface BackendInterface
 * @package ProgramCms\ConfigBundle\Model\Attribute\Backend
 */
interface BackendInterface
{
    /**
     * @param $fieldData
     * @return mixed
     */
    public function beforeSave(&$fieldData);
}