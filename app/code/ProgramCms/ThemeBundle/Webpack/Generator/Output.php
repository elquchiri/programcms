<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Webpack\Generator;

use ProgramCms\ThemeBundle\Webpack\GeneratorInterface;

/**
 * Class Output
 * @package ProgramCms\ThemeBundle\Webpack\Generator
 */
class Output implements GeneratorInterface
{
    /**
     * @var string
     */
    protected string $path = '';

    /**
     * @var string
     */
    protected string $filename = '';

    /**
     * @var string
     */
    protected string $publicPath = '';

    /**
     * Output constructor.
     * @param string $path
     * @param string $filename
     * @param string $publicPath
     */
    public function __construct(
        string $path,
        string $filename,
        string $publicPath
    )
    {
        $this->path = $path;
        $this->filename = $filename;
        $this->publicPath = $publicPath;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path): static
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $filename
     * @return $this
     */
    public function setFilename(string $filename): static
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $publicPath
     * @return $this
     */
    public function setPublicPath(string $publicPath): static
    {
        $this->publicPath = $publicPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublicPath(): string
    {
        return $this->publicPath;
    }

    /**
     * @return string
     */
    public function output(): string
    {
        $output = 'output:{';
        $output .= 'path:path.resolve(__dirname, ' . "'" . $this->path . "'" . '),';
        $output .= 'filename:' . "'" . $this->filename . "'" . ',';
        $output .= 'publicPath:' . "'" . $this->publicPath . "'" . ',';
        $output .= '}';
        return $output;
    }
}