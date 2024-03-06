<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Webpack;

/**
 * Interface GeneratorInterface
 * @package ProgramCms\ThemeBundle\Webpack
 */
interface GeneratorInterface
{
    /**
     * @return string
     */
    public function output(): string;
}