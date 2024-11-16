<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Controller\Adminhtml\Api;

use ProgramCms\AdminChatBundle\Entity\AdminConversation;
use ProgramCms\AdminChatBundle\Entity\AdminMessage;
use ProgramCms\AdminChatBundle\Repository\AdminConversationRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;

/**
 * Class MessagesController
 * @package ProgramCms\AdminChatBundle\Controller\Adminhtml\Api
 */
class MessagesController extends AdminController
{
    protected AdminConversationRepository $conversationRepository;

    /**
     * MessagesController constructor.
     * @param Context $context
     * @param AdminConversationRepository $conversationRepository
     */
    public function __construct(
        Context $context,
        AdminConversationRepository $conversationRepository
    )
    {
        parent::__construct($context);
        $this->conversationRepository = $conversationRepository;
    }

    public function execute()
    {
        $response = ['success' => false, 'messages' => []];
        $conversationId = $this->getRequest()->getParam('conversation_id');

        /** @var AdminConversation $conversation */
        $conversation = $this->conversationRepository->getById($conversationId);
        $messages = $conversation->getMessages();
        /** @var AdminMessage $message */
        foreach($messages as $message) {
            $response['messages'][] = [
                'id' => $message->getMessageId(),
                'user' => $message->getUser()->getShortName(),
                'content' => $message->getMessage(),
                'updatedAt' => $message->getUpdatedAt()
            ];
        }
        $response['success'] = true;
        return $this->json($response);
    }
}