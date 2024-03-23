<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Helper;

use ProgramCms\CoreBundle\App\Config;

/**
 * Class Context
 * @package ProgramCms\CoreBundle\Helper
 */
class Context
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * Context constructor.
     * @param Config $config
     */
    public function __construct(
        Config $config
    )
    {
        $this->config = $config;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }
}