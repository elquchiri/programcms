<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\App;

/**
 * Interface ScopeConfigInterface
 * @package ProgramCms\ConfigBundle\App
 */
interface ScopeConfigInterface
{
    const SCOPE_TYPE_DEFAULT = 'default';

    /**
     * @param $path
     * @param string $scopeType
     * @param int $scopeCode
     * @return mixed
     */
    public function getConfigValue($path, string $scopeType = self::SCOPE_TYPE_DEFAULT, string $scopeCode = '');

    /**
     * @param $path
     * @param $value
     * @param string $scopeType
     * @param int $scopeCode
     * @return mixed
     */
    public function setConfigValue($path, $value, string $scopeType = self::SCOPE_TYPE_DEFAULT, string $scopeCode = '');
}