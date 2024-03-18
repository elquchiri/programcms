<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\Fallback\Rule;

/**
 * Class Simple
 * @package ProgramCms\CoreBundle\View\Design\Fallback\Rule
 */
class Simple implements RuleInterface
{
    /**
     * @var array
     */
    protected array $optionalParams;

    /**
     * @var string
     */
    protected string $pattern;

    /**
     * Simple constructor.
     * @param string $pattern
     * @param array $optionalParams
     */
    public function __construct(
        string $pattern,
        array $optionalParams = []
    ) {
        $this->pattern = $pattern;
        $this->optionalParams = $optionalParams;
    }

    /**
     * @param array $params
     * @return array|string[]
     */
    public function getPatternDirs(array $params)
    {
        $pattern = $this->pattern;
        if (preg_match_all('/<([a-zA-Z\_]+)>/', $pattern, $matches)) {
            foreach ($matches[1] as $placeholder) {
                if (empty($params[$placeholder])) {
                    if (in_array($placeholder, $this->optionalParams)) {
                        return [];
                    } else {
                        throw new \InvalidArgumentException("Required parameter '{$placeholder}' was not passed");
                    }
                }
                $pattern = str_replace('<' . $placeholder . '>', $params[$placeholder], $pattern);
            }
        }
        return [$pattern];
    }
}