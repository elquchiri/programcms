<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Button;

/**
 * Class BackToUsersButton
 * @package ProgramCms\UserBundle\Model\Provider\Button
 */
class BackToUsersButton implements \ProgramCms\UiBundle\DataProvider\ButtonProviderInterface
{

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'back',
            'buttonAction' => '',
            'label' => 'back'
        ];
    }
}