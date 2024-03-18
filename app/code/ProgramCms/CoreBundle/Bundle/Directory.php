<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Bundle;

use Exception;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;

/**
 * Class Directory
 * @package ProgramCms\CoreBundle\Bundle
 */
class Directory
{
    const BUNDLE_RESOURCES_DIR = 'Resources';

    const BUNDLE_CONFIG_DIR = self::BUNDLE_RESOURCES_DIR . DIRECTORY_SEPARATOR . 'config';

    const BUNDLE_TRANSLATIONS_DIR = self::BUNDLE_RESOURCES_DIR . DIRECTORY_SEPARATOR . 'translations';

    const BUNDLE_VIEWS_DIR = self::BUNDLE_RESOURCES_DIR . DIRECTORY_SEPARATOR . 'views';

    const BUNDLE_CONTROLLER_DIR = 'Controller';

    const BUNDLE_SETUP_DIR = 'Setup';

    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * Directory constructor.
     * @param BundleManager $bundleManager
     */
    public function __construct(
        BundleManager $bundleManager
    )
    {
        $this->bundleManager = $bundleManager;
    }

    /**
     * @param $bundleName
     * @return mixed
     * @throws Exception
     */
    public function getDirectory($bundleName)
    {
        return $this->bundleManager->getBundleByName($bundleName);
    }
}