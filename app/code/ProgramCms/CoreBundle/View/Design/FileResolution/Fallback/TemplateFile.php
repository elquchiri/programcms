<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\FileResolution\Fallback;

use ProgramCms\CoreBundle\App\State;
use ProgramCms\CoreBundle\View\Asset\ConfigInterface;
use ProgramCms\CoreBundle\View\Design\ThemeInterface;
use ProgramCms\CoreBundle\View\Template\MinifierInterface;

/**
 * Class TemplateFile
 * @package ProgramCms\CoreBundle\View\Design\FileResolution\Fallback
 */
class TemplateFile extends File
{
    /**
     * @var State
     */
    protected State $state;

    /**
     * @var ConfigInterface
     */
    protected ConfigInterface $config;

    /**
     * @var MinifierInterface
     */
    protected MinifierInterface $minifier;

    /**
     * TemplateFile constructor.
     * @param ResolverInterface $resolver
     * @param State $state
     * @param ConfigInterface $config
     * @param MinifierInterface $minifier
     */
    public function __construct(
        ResolverInterface $resolver,
        State $state,
        ConfigInterface $config,
        MinifierInterface $minifier
    )
    {
        $this->state = $state;
        $this->config = $config;
        $this->minifier = $minifier;
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
        $template = parent::getFile($area, $themeModel, $file, $bundle);

        if ($template && $this->config->isMinifyTwig()) {
            return match ($this->state->getMode()) {
                State::MODE_PRODUCTION, State::MODE_DEVELOPER => $this->minifier->getMinified($template),
                default => $template,
            };
        }
        return $template;
    }

    /**
     * @return string
     */
    protected function getFallbackType(): string
    {
        return \ProgramCms\CoreBundle\View\Design\Fallback\RulePool::TYPE_TEMPLATE_FILE;
    }
}