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
 * Class Information
 * @package ProgramCms\UserBundle\Block\Account\Edit
 */
class Information extends Template
{
    /**
     * @return string
     */
    public function getSaveInformationUrl(): string
    {
        return $this->getUrl('user_save_information');
    }

    /**
     * @return string
     */
    public function getSaveProfileImageUrl(): string
    {
        return $this->getUrl('user_save_userimage');
    }
}