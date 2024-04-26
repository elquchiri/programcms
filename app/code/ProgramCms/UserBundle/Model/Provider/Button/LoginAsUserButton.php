<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Button;

use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class LoginAsUserButton
 * @package ProgramCms\UserBundle\Model\Provider\Button
 */
class LoginAsUserButton implements ButtonProviderInterface
{
    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'secondary',
            'buttonAction' => '',
            'label' => 'Login as User',
            'confirm' => [
                'title' => 'You are about to Login as User',
                'text' => "Actions taken while in 'Login as User' will affect actual user data. Please respect the user's privacy by asking for their consent before inspecting their user account.",
                'yes' => 'Login as User',
                'no' => 'Cancel'
            ]
        ];
    }
}