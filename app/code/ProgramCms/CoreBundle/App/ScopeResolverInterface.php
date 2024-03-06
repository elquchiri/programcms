<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

/**
 * Interface ScopeResolverInterface
 * @package ProgramCms\CoreBundle\App
 */
interface ScopeResolverInterface
{
    /**
     * Retrieve application scope object
     * @param null $scopeId
     * @return mixed
     */
    public function getScope($scopeId = null);

    /**
     * Retrieve scopes array
     * @return mixed
     */
    public function getScopes();
}