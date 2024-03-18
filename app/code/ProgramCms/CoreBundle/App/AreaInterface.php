<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

/**
 * Interface AreaInterface
 * @package ProgramCms\CoreBundle\App
 */
interface AreaInterface
{
    const PART_DESIGN = 'design';

    /**
     * @param string|null $part
     * @return mixed
     */
    public function load(string $part = null);
}