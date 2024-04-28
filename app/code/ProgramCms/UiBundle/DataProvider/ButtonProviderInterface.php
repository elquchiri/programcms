<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\DataProvider;

/**
 * Interface ButtonProviderInterface
 * @package ProgramCms\UiBundle\DataProvider
 */
interface ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getData(): array;
}