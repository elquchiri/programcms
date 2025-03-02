<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Component\Config;

use ProgramCms\UiBundle\Component\Form\Element\Button;

/**
 * Class StartServerButton
 * @package ProgramCms\AdminChatBundle\Component\Config
 */
class StartServerButton extends Button
{
    /**
     * @var string
     */
    protected string $_template = "@ProgramCmsAdminChatBundle/config/fields/start_server.html.twig";
}