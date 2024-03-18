<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\Fallback\Rule;

use InvalidArgumentException;

/**
 * Class Composite
 * @package ProgramCms\CoreBundle\View\Design\Fallback\Rule
 */
class Composite implements RuleInterface
{
    /**
     * Rules
     * @var RuleInterface[]
     */
    protected array $rules = [];

    /**
     * Composite constructor.
     * @param array $rules
     */
    public function __construct(array $rules)
    {
        foreach ($rules as $rule) {
            if (!$rule instanceof RuleInterface) {
                throw new InvalidArgumentException('Each item should implement the fallback rule interface.');
            }
        }
        $this->rules = $rules;
    }

    /**
     * Retrieve sequentially combined directory patterns from child fallback rules
     *
     * @param array $params
     * @return array
     */
    public function getPatternDirs(array $params)
    {
        $result = [];
        foreach ($this->rules as $rule) {
            $result = array_merge($result, $rule->getPatternDirs($params));
        }
        return $result;
    }
}