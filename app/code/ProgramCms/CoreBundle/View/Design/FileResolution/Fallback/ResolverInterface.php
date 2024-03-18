<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\FileResolution\Fallback;

use ProgramCms\CoreBundle\View\Design\ThemeInterface;

/**
 * Interface ResolverInterface
 * @package ProgramCms\CoreBundle\View\Design\FileResolution\Fallback
 */
interface ResolverInterface
{
    /**
     * @param $type
     * @param $file
     * @param null $area
     * @param ThemeInterface|null $theme
     * @param null $locale
     * @param null $bundle
     * @return mixed
     */
    public function resolve($type, $file, $area = null, ThemeInterface $theme = null, $locale = null, $bundle = null);

}