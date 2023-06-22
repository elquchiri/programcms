<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UiBundle\Model\Provider\DataSource;

/**
 * Interface OptionsInterface
 * @package ProgramCms\UiBundle\Model\Provider\DataSource
 */
interface OptionsInterface
{
    /**
     * @return array
     */
    public function getOptionsArray(): array;
}