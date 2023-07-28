<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DataPatchBundle\Model;

/**
 * Interface DataPatchInterface
 * @package ProgramCms\DataPatchBundle\Model
 */
interface DataPatchInterface
{
    public function execute(): void;
}