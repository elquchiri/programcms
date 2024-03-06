<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

/**
 * Interface ScopeConfigInterface
 * @package ProgramCms\CoreBundle\App
 */
interface ScopeConfigInterface
{
    /**
     * Default scope type
     */
    const SCOPE_TYPE_DEFAULT = 'default';

    /**
     * @param $path
     * @param string $scopeType
     * @param null $scopeCode
     * @return mixed
     */
    public function getValue($path, $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null);
}