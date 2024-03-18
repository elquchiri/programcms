<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model;

/**
 * Interface ObjectManagerInterface
 * @package ProgramCms\CoreBundle\Model
 */
interface ObjectManagerInterface
{
    /**
     * @param string $serviceId
     * @param array $arguments
     * @return object|null
     */
    public function create(string $serviceId, array $arguments = []): ?object;
}