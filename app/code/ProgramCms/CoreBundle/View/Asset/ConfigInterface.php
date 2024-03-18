<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Asset;

/**
 * Interface ConfigInterface
 * @package ProgramCms\CoreBundle\View\Asset
 */
interface ConfigInterface
{
    /**
     * @return bool
     */
    public function isMinifyTwig(): bool;
}