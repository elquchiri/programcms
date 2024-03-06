<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Webpack\Generator;

use ProgramCms\ThemeBundle\Webpack\Generator\Plugins\Plugin;
use ProgramCms\ThemeBundle\Webpack\GeneratorInterface;

/**
 * Class Plugins
 * @package ProgramCms\ThemeBundle\Webpack\Generator
 */
class Plugins implements GeneratorInterface
{
    /**
     * @var array<Plugin>
     */
    protected array $plugins = [];

    /**
     * Plugins constructor.
     * @param array $plugins
     */
    public function __construct(array $plugins)
    {
        $this->plugins = $plugins;
    }

    /**
     * @param Plugin $plugin
     * @return $this
     */
    public function addPlugin(Plugin $plugin): static
    {
        $this->plugins[] = $plugin;
        return $this;
    }

    /**
     * @return array
     */
    public function getPlugins(): array
    {
        return $this->plugins;
    }

    /**
     * @return string
     */
    public function output(): string
    {
        $output = 'plugins:[';
        foreach($this->plugins as $plugin) {
            $output .= $plugin->output() . ',';
        }
        $output .= ']';
        return $output;
    }
}