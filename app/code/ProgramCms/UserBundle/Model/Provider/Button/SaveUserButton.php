<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Button;

/**
 * Class SaveUserButton
 * @package ProgramCms\UserBundle\Model\Provider\Button
 */
class SaveUserButton implements \ProgramCms\UiBundle\DataProvider\ButtonProviderInterface
{

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'save',
            'buttonTarget' => 'user_form',
            'label' => 'Save User'
        ];
    }
}