<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider;

/**
 * Class AccountSharingOptions
 * @package ProgramCms\UserBundle\Model\Provider
 */
class AccountSharingOptions extends \ProgramCms\UiBundle\Model\Provider\DataSource\Options
{

    public function getOptionsArray(): array
    {
        return [
            'Global', 'Per Website'
        ];
    }
}