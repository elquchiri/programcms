<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\App;

use ProgramCms\CoreBundle\App\Config\ConfigTypeInterface;
use ProgramCms\CoreBundle\App\Config\ScopeCodeResolver;

/**
 * Class Config
 * @package ProgramCms\CoreBundle\App
 */
class Config implements ScopeConfigInterface
{
    /**
     * @var ConfigTypeInterface[]
     */
    protected array $types;

    /**
     * @var ScopeCodeResolver
     */
    protected ScopeCodeResolver $scopeCodeResolver;

    /**
     * Config constructor.
     * @param ScopeCodeResolver $scopeCodeResolver
     * @param array $types
     */
    public function __construct(
        ScopeCodeResolver $scopeCodeResolver,
        array $types = []
    )
    {
        $this->types = $types;
        $this->scopeCodeResolver = $scopeCodeResolver;
    }

    /**
     * @param null $path
     * @param string $scopeType
     * @param null $scopeCode
     * @return mixed
     */
    public function getValue(
        $path = null,
        $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    )
    {
        $configPath = $scopeType;
        if ($scopeType !== 'default') {
            if (is_numeric($scopeCode) || $scopeCode === null) {
                $scopeCode = $this->scopeCodeResolver->resolve($scopeType, $scopeCode);
            } elseif ($scopeCode instanceof ScopeInterface) {
                $scopeCode = $scopeCode->getCode();
            }
            if ($scopeCode) {
                $configPath .= '/' . $scopeCode;
            }
        }
        if ($path) {
            $configPath .= '/' . $path;
        }

        return $this->get('system', $configPath);
    }

    /**
     * @param $configType
     * @param string $path
     * @param null $default
     * @return mixed
     */
    public function get($configType, $path = '', $default = null)
    {
        return $this->types[$configType]->get($path);
    }
}