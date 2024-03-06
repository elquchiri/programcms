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
 * Class Rules
 * @package ProgramCms\ThemeBundle\Webpack\Generator\Module
 */
class Rules implements GeneratorInterface
{
    /**
     * @var array<Rule>
     */
    protected array $rules = [];

    /**
     * Rules constructor.
     * @param array $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param Rule $rule
     * @return $this
     */
    public function addRule(Rule $rule): static
    {
        $this->rules[] = $rule;
        return $this;
    }

    /**
     * @return Rule[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @return string
     */
    public function output(): string
    {
        $output = 'rules:[';
        foreach($this->rules as $rule) {
            $output .= $rule->output() . ',';
        }
        $output .= ']';
        return $output;
    }
}