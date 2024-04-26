<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DataPatchBundle\Model;

/**
 * Class AbstractDataPatch
 * @package ProgramCms\DataPatchBundle\Model
 */
abstract class AbstractDataPatch implements DataPatchInterface
{
    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }
}