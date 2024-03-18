<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Template;

/**
 * Interface MinifierInterface
 * @package ProgramCms\CoreBundle\View\Template
 */
interface MinifierInterface
{
    /**
     * @param $file
     * @return mixed
     */
    public function getMinified($file);
}