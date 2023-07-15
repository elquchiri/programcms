<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DependencyBundle\Exception;

use RuntimeException;

/**
 * Class BundleDependencyException
 * @package ProgramCms\BundleDependencyBundle\Exception
 */
class BundleDependencyException extends RuntimeException
{
    /**
     * BundleDependencyException constructor.
     * @param string $bundleNamespace
     */
    public function __construct(string $bundleNamespace)
    {
        $message = sprintf(
            'The class %s is a dependency to another bundle, but is not a BundleInterface implementation',
            $bundleNamespace
        );

        parent::__construct($message);
    }
}