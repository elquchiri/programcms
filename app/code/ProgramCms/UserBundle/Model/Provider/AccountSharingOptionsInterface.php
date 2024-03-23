<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider;

/**
 * Interface AccountSharingOptionsInterface
 * @package ProgramCms\UserBundle\Model\Provider
 */
interface AccountSharingOptionsInterface
{
    const GLOBAL = 0;

    const PER_WEBSITE = 1;

    const PER_WEBSITE_VIEW = 2;

    /**
     * @return array
     */
    public function getOptionsArray(): array;
}