<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\DataProvider;

use Doctrine\Common\Collections\AbstractLazyCollection;

/**
 * Interface DataProviderInterface
 * @package ProgramCms\UiBundle\DataProvider
 */
interface DataProviderInterface
{
    /**
     * Get primary field name
     * @return string
     */
    public function getPrimaryFieldName(): string;

    /**
     * Get field name in request
     * @return string
     */
    public function getRequestFieldName(): string;

    /**
     * Get data
     * @return mixed
     */
    public function getData(): mixed;

    /**
     * @return array
     */
    public function getCollection();
}