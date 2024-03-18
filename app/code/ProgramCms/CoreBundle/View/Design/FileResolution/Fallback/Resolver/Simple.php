<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\Resolver;

use ProgramCms\CoreBundle\View\Design\Fallback\Rule\RuleInterface;
use ProgramCms\CoreBundle\View\Design\Fallback\RulePool;
use ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\ResolverInterface;
use ProgramCms\CoreBundle\View\Design\ThemeInterface;
use Symfony\Component\Filesystem\Filesystem;
use ReflectionException;

/**
 * Class Simple
 * @package ProgramCms\CoreBundle\View\Design\FileResolution\Fallback\Resolver
 */
class Simple implements ResolverInterface
{
    /**
     * @var RulePool
     */
    protected RulePool $rulePool;

    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * Simple constructor.
     * @param RulePool $rulePool
     * @param Filesystem $filesystem
     */
    public function __construct(
        RulePool $rulePool,
        Filesystem $filesystem
    )
    {
        $this->rulePool = $rulePool;
        $this->filesystem = $filesystem;
    }

    /**
     * @param $type
     * @param $file
     * @param null $area
     * @param ThemeInterface|null $theme
     * @param null $locale
     * @param null $bundle
     * @return mixed
     * @throws ReflectionException
     */
    public function resolve($type, $file, $area = null, ThemeInterface $theme = null, $locale = null, $bundle = null)
    {
        $params = ['area' => $area, 'theme' => $theme, 'locale' => $locale];
        foreach ($params as $key => $param) {
            if ($param === null) {
                unset($params[$key]);
            }
        }
        if (!empty($bundle)) {
            $params['bundle_name'] = $bundle;
        }
        return $this->resolveFile($this->rulePool->getRule($type), $file, $params);
    }

    /**
     * @param RuleInterface $fallbackRule
     * @param $file
     * @param array $params
     * @return false|string
     */
    protected function resolveFile(RuleInterface $fallbackRule, $file, array $params = [])
    {
        $params['file'] = $file;
        foreach ($fallbackRule->getPatternDirs($params) as $dir) {
            $path = "{$dir}/{$file}";
            // If file dont exists, fallback.
            if($this->filesystem->exists($path)) {
                return $path;
            }
        }
        return false;
    }
}