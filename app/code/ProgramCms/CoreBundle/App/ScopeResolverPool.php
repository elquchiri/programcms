<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

/**
 * Class ScopeResolverPool
 * @package ProgramCms\CoreBundle\App
 */
class ScopeResolverPool
{
    /**
     * @var ScopeResolverInterface[]
     */
    protected array $scopeResolvers = [];

    /**
     * ScopeResolverPool constructor.
     * @param array $scopeResolvers
     */
    public function __construct(
        array $scopeResolvers = []
    ) {
        $this->scopeResolvers = $scopeResolvers;
    }

    /**
     * @param $scopeType
     * @return ScopeResolverInterface
     */
    public function get($scopeType): ScopeResolverInterface
    {
        if (!isset($this->scopeResolvers[$scopeType]) ||
            !($this->scopeResolvers[$scopeType] instanceof ScopeResolverInterface)
        ) {
            throw new \InvalidArgumentException("Invalid scope type '{$scopeType}'");
        }
        return $this->scopeResolvers[$scopeType];
    }
}