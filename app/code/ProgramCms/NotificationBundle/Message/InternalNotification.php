<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\NotificationBundle\Message;

/**
 * Class InternalNotification
 * @package ProgramCms\NotificationBundle\Message
 */
class InternalNotification
{
    /**
     * InternalNotification constructor.
     * @param string $content
     */
    public function __construct(
        private string $content = "",
    ) {
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}