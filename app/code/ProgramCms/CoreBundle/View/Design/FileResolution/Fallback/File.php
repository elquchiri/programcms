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
 * Class File
 * @package ProgramCms\CoreBundle\View\Design\FileResolution\Fallback
 */
class File
{
    /**
     * @var ResolverInterface
     */
    protected ResolverInterface $resolver;

    /**
     * File constructor.
     * @param ResolverInterface $resolver
     */
    public function __construct(
        ResolverInterface $resolver
    )
    {
        $this->resolver = $resolver;
    }

    /**
     * @param $area
     * @param ThemeInterface $themeModel
     * @param $file
     * @param null $bundle
     * @return mixed
     */
    public function getFile($area, ThemeInterface $themeModel, $file, $bundle = null)
    {
        return $this->resolver->resolve(
            $this->getFallbackType(),
            $file,
            $area,
            $themeModel,
            null,
            $bundle
        );
    }

    /**
     * @return string
     */
    protected function getFallbackType(): string
    {
        return \ProgramCms\CoreBundle\View\Design\Fallback\RulePool::TYPE_FILE;
    }
}