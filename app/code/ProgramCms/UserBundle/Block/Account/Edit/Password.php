<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block\Account\Edit;

use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class Password
 * @package ProgramCms\UserBundle\Block\Account\Edit
 */
class Password extends Template
{
    /**
     * @return string
     */
    public function getSavePasswordUrl(): string
    {
        return $this->getUrl('user_save_password');
    }
}