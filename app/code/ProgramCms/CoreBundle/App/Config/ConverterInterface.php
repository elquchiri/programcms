<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App\Config;

/**
 * Interface ConverterInterface
 * @package ProgramCms\CoreBundle\App\Config
 */
interface ConverterInterface
{
    /**
     * Convert config
     * @param $source
     * @return mixed
     */
    public function convert($source);
}