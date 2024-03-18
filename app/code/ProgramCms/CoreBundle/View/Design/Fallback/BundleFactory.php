<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Design\Fallback;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Design\Fallback\Rule\Bundle;
use ReflectionException;

/**
 * Class BundleFactory
 * @package ProgramCms\CoreBundle\View\Design\Fallback
 */
class BundleFactory
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * ModularSwitchFactory constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(
        ObjectManager $objectManager
    )
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param array $data
     * @return object|null
     * @throws ReflectionException
     */
    public function create(array $data): ?object
    {
        return $this->objectManager->create(Bundle::class, $data);
    }
}