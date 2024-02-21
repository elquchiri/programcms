<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Webpack;

/**
 * Class WebpackConfig
 * @package ProgramCms\CoreBundle\Webpack
 */
class WebpackConfig
{
    /**
     * @var array
     */
    protected array $entry = [];

    /**
     * @var array
     */
    protected array $output = [];

    /**
     * @var array
     */
    protected array $module = [];

    /**
     * WebpackConfig constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $name
     * @param array $entries
     * @return $this
     */
    public function addEntry(string $name, array $entries): static
    {
        $this->entry[$name] = $entries;
        return $this;
    }

    /**
     * @return array
     */
    public function getEntries(): array
    {
        return $this->entry;
    }

    /**
     * @param string $path
     * @param string $filename
     * @param string $publicPath
     * @return $this
     */
    public function addOutput(string $path, string $filename, string $publicPath): static
    {
        $this->output = [
            'path' => $path,
            'filename' => $filename,
            'publicPath' => $publicPath
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getOutput(): array
    {
        return $this->output;
    }

    public function addModuleRule(string $test, array $use)
    {
        $this->module['rules'][] = [

        ];
    }

    public function generateWebpackConfig()
    {

    }
}