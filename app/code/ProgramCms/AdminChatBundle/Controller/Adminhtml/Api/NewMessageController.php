<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Controller\Adminhtml\Api;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminBundle\Repository\AdminUserRepository;
use ProgramCms\AdminChatBundle\Entity\AdminConversation;
use ProgramCms\AdminChatBundle\Entity\AdminMessage;
use ProgramCms\AdminChatBundle\Helper\ConversationHelper;
use ProgramCms\AdminChatBundle\Repository\AdminConversationRepository;
use ProgramCms\AdminChatBundle\Repository\AdminMessageRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class NewMessageController
 * @package ProgramCms\AdminChatBundle\Controller\Adminhtml\Api
 */
class NewMessageController extends AdminController
{
    /**
     * @var AdminMessageRepository
     */
    protected AdminMessageRepository $messageRepository;

    /**
     * @var AdminConversationRepository
     */
    protected AdminConversationRepository $conversationRepository;

    /**
     * @var AdminUserRepository
     */
    protected AdminUserRepository $adminUserRepository;

    /**
     * @var ConversationHelper
     */
    protected ConversationHelper $conversationHelper;

    /**
     * NewMessageController constructor.
     * @param Context $context
     * @param AdminConversationRepository $conversationRepository
     * @param AdminMessageRepository $messageRepository
     * @param AdminUserRepository $adminUserRepository
     * @param ConversationHelper $conversationHelper
     */
    public function __construct(
        Context $context,
        AdminConversationRepository $conversationRepository,
        AdminMessageRepository $messageRepository,
        AdminUserRepository $adminUserRepository,
        ConversationHelper $conversationHelper
    )
    {
        parent::__construct($context);
        $this->messageRepository = $messageRepository;
        $this->conversationRepository = $conversationRepository;
        $this->adminUserRepository = $adminUserRepository;
        $this->conversationHelper = $conversationHelper;
    }

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        $response = ['success' => false, 'data' => []];

        $data = $this->getRequest()->getCurrentRequest()->toArray();
        $conversationId = (int) $data['conversation_id'];

        if (empty($conversationId)) {
            $users = explode(',', $data['users']);
            $conversation = new AdminConversation();
            $conversation->setTitle("");

            // Add Current User to conversation
            $conversation->addUser($this->getUser());
            foreach($users as $userId) {
                /** @var AdminUser $user */
                $user = $this->adminUserRepository->getById($userId);
                $conversation->addUser($user);
            }
        }else{
            /** @var AdminConversation $conversation */
            $conversation = $this->conversationRepository->getById($conversationId);
        }

        $messageContent = $data['message'];
        /** @var AdminUser $user */
        $user = $this->getUser();
        if (empty($messageContent)) {
            $response['success'] = false;
        }

        $message = new AdminMessage();
        $message
            ->setUser($user)
            ->setConversation($conversation)
            ->setMessage($messageContent)
            ->updateTimestamps();

        $conversation->addMessage($message);
        $this->conversationRepository->save($conversation);

        $response['success'] = true;
        $response['data'] = [
            'conversationId' => $conversation->getConversationId(),
            'conversationTitle' => $this->conversationHelper->formatConversationUsers($conversation),
            'message' => $message->getMessage(),
            'updatedAt' => $message->getUpdatedAt()
        ];

        return $this->json($response);
    }
}