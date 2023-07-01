<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Controller;

/**
 * Interface ControllerInterface
 * @package ProgramCms\CoreBundle\Controller
 */
interface ControllerInterface
{
    /**
     * @return mixed
     */
    public function execute();
}