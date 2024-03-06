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
 * Class Entry
 * @package ProgramCms\ThemeBundle\Webpack\Generator
 */
class Entry implements GeneratorInterface
{
    /**
     * @var array
     */
    protected array $entry = [];

    /**
     * Entry constructor.
     * @param array $entry
     */
    public function __construct(array $entry)
    {
        $this->entry = $entry;
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
     * @return string
     */
    public function output(): string
    {
        $output = "entry: {";
        foreach($this->entry as $entryName => $entries) {
            $output .= $entryName . ":[" . implode(',', $entries) . "]";
        }
        $output .= "}";
        return $output;
    }
}