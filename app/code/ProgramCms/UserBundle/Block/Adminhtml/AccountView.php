<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Block\Adminhtml;

use ProgramCms\UiBundle\Component\AbstractComponent;

/**
 * Class AccountView
 * @package ProgramCms\UserBundle\Block\Adminhtml
 */
class AccountView extends AbstractComponent
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsUser/account_view.html.twig";

    public function getComponentName()
    {

    }
}