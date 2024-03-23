<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Helper;

use ProgramCms\CoreBundle\App\Config;
use ProgramCms\CoreBundle\App\ScopeConfigInterface;

/**
 * Class AbstractHelper
 * @package ProgramCms\CoreBundle\Helper
 */
abstract class AbstractHelper implements AbstractHelperInterface
{
    /**
     * @var Context
     */
    protected Context $context;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * AbstractHelper constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    )
    {
        $this->context = $context;
        $this->config = $context->getConfig();
    }

    /**
     * @param string $path
     * @param string $scopeType
     * @param null $scopeCode
     * @return mixed
     */
    public function getConfig(
        string $path,
        string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
        $scopeCode = null
    )
    {
        return $this->config->getValue($path, $scopeType, $scopeCode);
    }
}