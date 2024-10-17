<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Model\Provider\Button\Role;

use ProgramCms\UiBundle\DataProvider\ButtonProviderInterface;

/**
 * Class Save
 * @package ProgramCms\AclBundle\Model\Provider\Button\Role
 */
class Save implements ButtonProviderInterface
{
    /**
     * @return string[]
     */
    public function getData(): array
    {
        return [
            'buttonType' => 'save',
            'buttonTarget' => 'role_form',
            'label' => 'Save Role'
        ];
    }
}