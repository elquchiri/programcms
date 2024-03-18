<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block\Account;

/**
 * Class Register
 * @package ProgramCms\UserBundle\Block\Account
 */
class Register extends \ProgramCms\CoreBundle\View\Element\Template
{

    public function getRulesAndPolicy()
    {
        return sprintf(
            $this->trans('I accept %s and %s'),
            '<a href="#">' . $this->trans('The conditions') . '</a>',
            '<a href="#">' . $this->trans('Confidential policy') . '</a>'
        );
    }
}