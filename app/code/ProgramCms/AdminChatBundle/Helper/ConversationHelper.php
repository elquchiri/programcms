<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Helper;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminChatBundle\Entity\AdminConversation;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class ConversationHelper
 * @package ProgramCms\AdminChatBundle\Helper
 */
class ConversationHelper
{
    /**
     * @var Security
     */
    protected Security $security;

    /**
     * ConversationHelper constructor.
     * @param Security $security
     */
    public function __construct(
        Security $security
    )
    {
        $this->security = $security;
    }

    /**
     * @param AdminConversation $conversation
     * @return string
     */
    public function formatConversationUsers(AdminConversation $conversation): string
    {
        $title = "";
        $users = $conversation->getUsers();
        /** @var AdminUser $user */
        foreach($users as $index => $user) {
            if($user->getUserId() === $this->security->getUser()->getEntityId()) {
                continue;
            }

            $title .= $user->getFirstName() . " " . $user->getLastName()[0];
            if($index < count($users) - 1) {
                $title .= " + ";
            }
        }
        return $title;
    }
}