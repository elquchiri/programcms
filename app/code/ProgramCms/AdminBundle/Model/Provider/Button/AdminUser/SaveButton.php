<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Model\Provider\Button\AdminUser;

use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class SaveButton
 * @package ProgramCms\AdminBundle\Model\Provider\Button\AdminUser
 */
class SaveButton implements ButtonProviderInterface
{
    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'save',
            'buttonTarget' => 'admin_user_form',
            'label' => 'Save Admin'
        ];
    }
}