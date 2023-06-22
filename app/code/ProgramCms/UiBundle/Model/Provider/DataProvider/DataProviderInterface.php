<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Provider\DataProvider;

/**
 * Interface DataProviderInterface
 * @package ProgramCms\UiBundle\Model\Provider\DataProvider
 */
interface DataProviderInterface
{
    /**
     * @return mixed
     */
    public function getData(): mixed;
}