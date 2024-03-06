<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

use ProgramCms\CoreBundle\Model\ObjectManager;

/**
 * Class ScopeResolver
 * @package ProgramCms\CoreBundle\App
 */
class ScopeResolver implements ScopeResolverInterface
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var ScopeInterface
     */
    private $defaultScope;

    /**
     * ScopeResolver constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @return object|ScopeInterface|null
     */
    public function getScope($scopeId = null)
    {
        if (!$this->defaultScope) {
            $this->defaultScope = $this->objectManager->create(DefaultScope::class);
        }

        return $this->defaultScope;
    }

    /**
     * Retrieve a list of available scopes
     * @return ScopeInterface[]
     */
    public function getScopes()
    {
        return [$this->defaultScope];
    }
}
