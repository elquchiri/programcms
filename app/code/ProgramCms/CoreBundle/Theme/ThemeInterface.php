<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Theme;

/**
 * Interface ThemeInterface
 * @package ProgramCms\CoreBundle\Theme
 */
interface ThemeInterface
{
    /**
     * Default Area
     */
    const DEFAULT_AREA = 'frontend';

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getParent(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getNamespace(): string;

    /**
     * @return string
     */
    public function getArea(): string;
}