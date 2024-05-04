<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\AdminChatBundle\Helper\Data as ChatHelper;

/**
 * Class ChatWidget
 * @package ProgramCms\AdminChatBundle\Block
 */
class ChatWidget extends Template
{
    protected ChatHelper $chatHelper;

    /**
     * ChatWidget constructor.
     * @param Template\Context $context
     * @param ChatHelper $chatHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ChatHelper $chatHelper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->chatHelper = $chatHelper;
    }

    /**
     * @return mixed
     */
    public function isChatEnabled()
    {
        return (bool) $this->chatHelper->isChatEnabled();
    }
}