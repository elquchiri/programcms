<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App\Config;

/**
 * Interface ConfigTypeInterface
 * @package ProgramCms\CoreBundle\App\Config
 */
interface ConfigTypeInterface
{

    /**
     * @param string $path
     * @return mixed
     */
    public function get($path = '');
}