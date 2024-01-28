<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Button;

/**
 * Class DeleteUserButton
 * @package ProgramCms\UserBundle\Model\Provider\Button
 */
class DeleteUserButton implements \ProgramCms\UiBundle\DataProvider\ButtonProviderInterface
{

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'secondary',
            'buttonAction' => '',
            'label' => 'Delete User'
        ];
    }
}