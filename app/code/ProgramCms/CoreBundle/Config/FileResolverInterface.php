<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Config;

/**
 * Interface FileResolverInterface
 * @package ProgramCms\CoreBundle\Config
 */
interface FileResolverInterface
{
    /**
     * @param $filename
     * @param $scope
     * @return mixed
     */
    public function get($filename, $scope);
}