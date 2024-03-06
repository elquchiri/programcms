<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Webpack\Generator\Module;

use ProgramCms\ThemeBundle\Webpack\GeneratorInterface;

/**
 * Class Rule
 * @package ProgramCms\ThemeBundle\Webpack\Generator\Module
 */
class Rule implements GeneratorInterface
{

    const STRING_MODE = 'string';

    const JS_MODE = 'js';

    /**
     * @var string
     */
    protected string $test = '';

    /**
     * @var array
     */
    protected array $use = [];

    /**
     * Rule constructor.
     * @param string $test
     * @param array $use
     */
    public function __construct(
        string $test,
        array $use
    )
    {
        $this->test = $test;
        $this->use = $use;
    }

    /**
     * @param string $test
     * @return $this
     */
    public function setTest(string $test): static
    {
        $this->test = $test;
        return $this;
    }

    /**
     * @return string
     */
    public function getTest(): string
    {
        return $this->test;
    }

    /**
     * @param $use
     * @param string $mode
     * @return Rule
     */
    public function addUse($use, $mode = self::STRING_MODE): static
    {
        $this->use[] = ['loader' => $use, 'mode' => $mode];
        return $this;
    }

    /**
     * @return array
     */
    public function getUse(): array
    {
        return $this->use;
    }

    /**
     * @return string
     */
    public function output(): string
    {
        $output = "{";
        $output .= 'test:' . $this->test . ',';
        $output .= 'use:[';
        foreach($this->use as $use) {
            $output .= $use['mode'] === self::STRING_MODE ? "'" . $use['loader'] . "'" : $use['loader'];
            $output .= ',';
        }
        $output .= ']';
        $output .= "}";
        return $output;
    }
}