<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider;


class AccountSharingOptions implements \ProgramCms\ConfigBundle\Model\OptionsArrayProvider
{

    public function getOptionsArray()
    {
        return [
            'Global', 'Per Website'
        ];
    }
}