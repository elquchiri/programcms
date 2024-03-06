<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Webpack\Generator\Plugins;

use ProgramCms\ThemeBundle\Webpack\GeneratorInterface;

/**
 * Class Plugin
 * @package ProgramCms\ThemeBundle\Webpack\Generator\Plugins
 */
class Plugin implements GeneratorInterface
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var array
     */
    protected array $params = [];

    /**
     * Plugin constructor.
     * @param string $name
     * @param array $params
     */
    public function __construct(string $name, array $params)
    {
        $this->name = $name;
        $this->params = $params;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addParam(string $key, $value)
    {
        $this->params[$key] = $value;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function output(): string
    {
        $output = 'new ' . $this->name . '({';
        foreach($this->params as $key => $value) {
            $output .= $key . ':' . "'" . $value . "'" . ',';
        }
        $output .= '})';
        return $output;
    }
}