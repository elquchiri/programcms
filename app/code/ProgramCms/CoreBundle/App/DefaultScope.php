<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

/**
 * Class DefaultScope
 * @package ProgramCms\CoreBundle\App
 */
class DefaultScope implements ScopeInterface
{
    /**
     * Retrieve scope code
     * @return string
     */
    public function getCode()
    {
        return '';
    }

    /**
     * Get scope identifier
     * @return int
     */
    public function getId()
    {
        return 0;
    }

    /**
     * Get scope type
     * @return string
     */
    public function getScopeType()
    {
        return self::SCOPE_DEFAULT;
    }

    /**
     * Get scope type name
     * @return string
     */
    public function getScopeTypeName()
    {
        return 'Default Scope';
    }

    /**
     * Get scope name
     * @return string
     */
    public function getName()
    {
        return 'Default';
    }
}
