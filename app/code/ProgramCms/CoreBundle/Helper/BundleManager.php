<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Helper;

/**
 * Class BundleManager
 * @package ProgramCms\CoreBundle\Helper
 */
class BundleManager
{
    /**
     * Called to check weather bundle extends ProgramCmsCoreBundle class
     * @see \ProgramCms\CoreBundle\Model\Utils\BundleManager::getAllBundles
     */
    public const PROGRAMCMS_METHOD_DEFINER = 'isProgramCmsBundle';
}