<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Helper;

use ProgramCms\CoreBundle\App\ScopeInterface;
use ProgramCms\CoreBundle\Helper\AbstractHelper;

/**
 * Class Data
 * @package ProgramCms\AdminBundle\Helper
 */
class Data extends AbstractHelper
{
    const BREADCRUMB_CONFIG = 'system/backend_theme/breadcrumb';

    /**
     * @return bool
     */
    public function isBreadcrumbEnabled(): bool
    {
        return (bool) $this->getConfig(
            self::BREADCRUMB_CONFIG,
            ScopeInterface::SCOPE_DEFAULT
        );
    }
}