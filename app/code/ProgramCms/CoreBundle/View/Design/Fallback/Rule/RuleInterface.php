<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\Fallback\Rule;

/**
 * Interface RuleInterface
 * @package ProgramCms\CoreBundle\View\Design\Fallback\Rule
 */
interface RuleInterface
{
    /**
     * Get an ordered list of folders to find a file
     * @param array $params
     * @return mixed
     */
    public function getPatternDirs(array $params);
}