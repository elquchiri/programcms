<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\NotificationBundle\MessageHandler;

use ProgramCms\NotificationBundle\Message\InternalNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class InternalNotificationHandler
{
    /**
     * @param InternalNotification $message
     */
    public function __invoke(InternalNotification $message)
    {
        // TODO: Implement __invoke() method.
    }
}