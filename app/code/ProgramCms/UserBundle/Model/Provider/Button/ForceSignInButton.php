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
                'title' => 'You are about to Force Sign In',
                'text' => "Taking actions that affect user data, such as making changes or deletions, will lead to the termination of the current session. Consequently, the user will be prompted to log in again the next time they visit the site in order to resume their activities and access their personalized data and settings. This process ensures security and protects the integrity of the user's information.",
                'yes' => 'Force Sign In',
                'no' => 'Cancel'
            ]
        ];
    }
}