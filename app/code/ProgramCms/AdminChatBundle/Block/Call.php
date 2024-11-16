<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Block;

use Doctrine\Common\Collections\Collection;
use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminChatBundle\Entity\AdminConversation;
use ProgramCms\AdminChatBundle\Helper\Data as ChatHelper;
use ProgramCms\AdminChatBundle\Repository\AdminConversationRepository;
use ProgramCms\CoreBundle\View\Element\Template;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class Call
 * @package ProgramCms\AdminChatBundle\Block
 */
class Call extends ChatWidget
{
    /**
     * @var AdminConversationRepository
     */
    protected AdminConversationRepository $conversationRepository;
    protected Security $security;

    /**
     * Call constructor.
     * @param Template\Context $context
     * @param ChatHelper $chatHelper
     * @param Security $security
     * @param AdminConversationRepository $conversationRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ChatHelper $chatHelper,
        Security $security,
        AdminConversationRepository $conversationRepository,
        array $data = []
    )
    {
        parent::__construct($context, $chatHelper, $security, $data);
        $this->conversationRepository = $conversationRepository;
        $this->security = $security;
    }

    /**
     * @return Collection|array
     */
    public function getUsers(): Collection|array
    {
        $users = [];
        $conversationId = $this->getRequest()->getParam('id');
        /** @var AdminConversation $conversation */
        $conversation = $this->conversationRepository->getById($conversationId);
        if($conversation) {
            foreach($conversation->getUsers() as $user) {
                if($user === $this->getUser()) {
                    continue;
                }
                $users[] = $user;
            }
        }
        return $users;
    }

    /**
     * @return int
     */
    public function countUsers(): int
    {
        return count($this->getUsers());
    }

    /**
     * @return string
     */
    public function getUsersIds(): string
    {
        $ids = [];
        /** @var AdminUser $user */
        foreach($this->getUsers() as $user) {
            $ids[] = $user->getUserId();
        }
        return json_encode($ids);
    }

    /**
     * @return AdminConversation|null
     */
    public function getConversation(): ?AdminConversation
    {
        $conversationId = $this->getRequest()->getParam('id');
        return $this->conversationRepository->getById($conversationId);
    }
}