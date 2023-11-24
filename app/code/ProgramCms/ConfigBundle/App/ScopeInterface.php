<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ConfigBundle\App;


interface ScopeInterface
{
    /**
     * Default scope reference code
     */
    const SCOPE_DEFAULT = 'default';

    /**
     * Retrieve scope code
     * @return string
     */
    public function getCode();

    /**
     * Get scope identifier
     * @return int
     */
    public function getId();

    /**
     * Get scope type
     * @return string
     */
    public function getScopeType();

    /**
     * Get scope type name
     * @return string
     */
    public function getScopeTypeName();

    /**
     * Get scope name
     * @return string
     */
    public function getName();
}