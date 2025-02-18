<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Button;

/**
 * Class ResetPasswordButton
 * @package ProgramCms\UserBundle\Model\Provider\Button
 */
class ResetPasswordButton implements \ProgramCms\UiBundle\DataProvider\ButtonProviderInterface
{

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'secondary',
            'buttonAction' => '',
            'label' => 'Reset Password',
            'confirm' => [
                'title' => 'Account Recovery',
                'text' => 'You are about to send user an account recovery email',
                'yes' => 'Send Recovery Email'
            ]
        ];
    }
}