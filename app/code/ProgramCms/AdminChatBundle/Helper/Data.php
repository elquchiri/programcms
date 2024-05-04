<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Helper;

use ProgramCms\CoreBundle\Helper\AbstractHelper;

/**
 * Class Data
 * @package ProgramCms\AdminChatBundle\Helper
 */
class Data extends AbstractHelper
{
    const ENABLE_CHAT_CONFIG = 'system/live_chat/enable';

    /**
     * @return mixed
     */
    public function isChatEnabled()
    {
        return $this->getConfig(self::ENABLE_CHAT_CONFIG);
    }
}