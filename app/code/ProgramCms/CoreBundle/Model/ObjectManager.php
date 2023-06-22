<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model;

/**
 * Class ObjectManager
 * @package ProgramCms\CoreBundle\Model
 */
class ObjectManager implements ObjectManagerInterface
{

    protected Utils\BundleManager $bundleManager;

    public function __construct(
        \ProgramCms\CoreBundle\Model\Utils\BundleManager $bundleManager
    )
    {
        $this->bundleManager = $bundleManager;
    }

    /**
     * @param string $serviceId
     * @return object|null
     */
    public function create(string $serviceId): ?object
    {
        return clone $this->bundleManager->getContainer()->get($serviceId);
    }
}