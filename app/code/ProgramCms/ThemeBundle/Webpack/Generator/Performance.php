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
 * Class Performance
 * @package ProgramCms\ThemeBundle\Webpack\Generator
 */
class Performance implements GeneratorInterface
{
    /**
     * @var bool
     */
    protected bool $hints = false;

    /**
     * @var int
     */
    protected int $maxEntrypointSize;

    /**
     * @var int
     */
    protected int $maxAssetSize;

    /**
     * Performance constructor.
     * @param bool $hints
     * @param int $maxEntrypointSize
     * @param int $maxAssetSize
     */
    public function __construct(
        bool $hints,
        int $maxEntrypointSize,
        int $maxAssetSize
    )
    {
        $this->hints = $hints;
        $this->maxEntrypointSize = $maxEntrypointSize;
        $this->maxAssetSize = $maxAssetSize;
    }

    /**
     * @return string
     */
    public function output(): string
    {
        $output = 'performance:{';
        $output .= 'hints:' . ($this->hints ? 'true' : 'false') . ',';
        $output .= 'maxEntrypointSize:' . $this->maxEntrypointSize . ',';
        $output .= 'maxAssetSize:' . $this->maxAssetSize;
        $output .= '}';
        return $output;
    }
}