<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\FileResolution\Fallback;

use ProgramCms\CoreBundle\App\State;
use ProgramCms\CoreBundle\View\Design\Fallback\RulePool;
use ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\Resolver\Merge;
use ProgramCms\CoreBundle\View\Design\ThemeInterface;

/**
 * Class AssetFile
 * @package ProgramCms\CoreBundle\View\Design\FileResolution\Fallback
 */
class AssetFile extends File
{
    /**
     * @var ResolverInterface
     */
    protected ResolverInterface $resolver;

    /**
     * @var State
     */
    protected State $state;

    /**
     * LayoutFile constructor.
     * @param Merge $resolver
     * @param State $state
     */
    public function __construct(
        Merge $resolver,
        State $state,
    )
    {
        $this->state = $state;
        parent::__construct($resolver);
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
        return parent::getFile($area, $themeModel, $file, $bundle);
    }

    /**
     * @return string
     */
    protected function getFallbackType(): string
    {
        return RulePool::TYPE_ASSET_FILE;
    }
}