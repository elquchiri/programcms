<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Button\Address;

use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class SaveAddressButton
 * @package ProgramCms\UserBundle\Model\Provider\Button\Address
 */
class SaveAddressButton implements ButtonProviderInterface
{
    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'save',
            'buttonTarget' => 'user_address_form',
            'label' => 'Save Address'
        ];
    }
}