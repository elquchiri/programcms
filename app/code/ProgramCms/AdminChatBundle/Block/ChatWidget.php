<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Block;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\AdminChatBundle\Helper\Data as ChatHelper;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class ChatWidget
 * @package ProgramCms\AdminChatBundle\Block
 */
class ChatWidget extends Template
{
    /**
     * @var ChatHelper
     */
    protected ChatHelper $chatHelper;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * ChatWidget constructor.
     * @param Template\Context $context
     * @param ChatHelper $chatHelper
     * @param Security $security
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ChatHelper $chatHelper,
        Security $security,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->chatHelper = $chatHelper;
        $this->security = $security;
    }

    /**
     * @return bool
     */
    public function isChatEnabled(): bool
    {
        return (bool) $this->chatHelper->isChatEnabled();
    }

    /**
     * @return AdminUser
     */
    public function getUser(): AdminUser
    {
        return $this->security->getUser();
    }

    /**
     * Get Session
     */
    public function getSessionId()
    {
        $session = $this->getRequest()->getCurrentRequest()->getSession();
        if (!$session->isStarted()) {
            $session->start();
        }
        return $this->getRequest()->getCurrentRequest()->getSession()->getId();
    }
}