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
 * Class Module
 * @package ProgramCms\ThemeBundle\Webpack\Generator
 */
class Module implements GeneratorInterface
{
    /**
     * @var array
     */
    protected array $elements = [];

    /**
     * Module constructor.
     * @param array $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @return string
     */
    public function output(): string
    {
        $output = "module:{";
        foreach($this->elements as $element) {
            $output .= $element->output() . ',';
        }
        $output .= '}';
        return $output;
    }
}