<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\UserBundle\Model\Provider;


class AccountSharingOptions implements \ElectroForums\ConfigBundle\Model\OptionsArrayProvider
{

    public function getOptionsArray()
    {
        return [
            'Global', 'Per Website'
        ];
    }
}