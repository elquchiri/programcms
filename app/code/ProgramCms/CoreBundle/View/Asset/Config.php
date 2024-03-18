<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Asset;

use ProgramCms\CoreBundle\App\Config as AppConfig;

/**
 * Class Config
 * @package ProgramCms\CoreBundle\View\Asset
 */
class Config implements ConfigInterface
{
    const TWIG_MINIFICATION_CONFIG = 'developer/template_settings/minify_twig';

    /**
     * @var AppConfig
     */
    protected AppConfig $config;

    /**
     * Config constructor.
     * @param AppConfig $config
     */
    public function __construct(
        AppConfig $config
    )
    {
        $this->config = $config;
    }

    /**
     * @return bool
     */
    public function isMinifyTwig(): bool
    {
        return $this->config->isTrue(self::TWIG_MINIFICATION_CONFIG);
    }
}