<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model;

use ProgramCms\CoreBundle\Model\Utils\BundleManager;

/**
 * Class ObjectManager
 * @package ProgramCms\CoreBundle\Model
 */
class ObjectManager implements ObjectManagerInterface
{
    /**
     * @var Utils\BundleManager
     */
    protected Utils\BundleManager $bundleManager;

    /**
     * ObjectManager constructor.
     * @param Utils\BundleManager $bundleManager
     */
    public function __construct(
        BundleManager $bundleManager
    )
    {
        $this->bundleManager = $bundleManager;
    }

    /**
     * Clones a service and returns a new instance of the object
     * @param string $serviceId
     * @return object|null
     */
    public function create(string $serviceId): ?object
    {
        return clone $this->bundleManager->getContainer()->get($serviceId);
    }
}