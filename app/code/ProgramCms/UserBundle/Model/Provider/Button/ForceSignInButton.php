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
 * Class ForceSignInButton
 * @package ProgramCms\UserBundle\Model\Provider\Button
 */
class ForceSignInButton implements ButtonProviderInterface
{
    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'secondary',
            'buttonAction' => '',
            'label' => 'Force Sign In',
            'confirm' => [
                'title' => 'You are about to Login as User',
                'text' => 'Actions taken while in "Login as User" will affect actual user data.',
                'yes' => 'Login as User',
                'no' => 'Cancel'
            ]
        ];
    }
}