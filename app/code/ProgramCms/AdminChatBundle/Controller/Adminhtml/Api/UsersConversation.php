<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Controller\Adminhtml\Api;

use ProgramCms\AdminChatBundle\Entity\AdminMessage;
use ProgramCms\AdminChatBundle\Repository\AdminConversationRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UsersConversation
 * @package ProgramCms\AdminChatBundle\Controller\Adminhtml\Api
 */
class UsersConversation extends AdminController
{
    /**
     * @var AdminConversationRepository
     */
    protected AdminConversationRepository $conversationRepository;

    /**
     * UsersConversation constructor.
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

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        $response = ['success' => false, 'data' => []];
        $users = explode(',', $this->getRequest()->getParam('users'));
        $users[] = $this->getUser()->getUserId();
        $conversation = $this->conversationRepository->findConversationByUsers($users);

        if($conversation) {
            $response['success'] = true;
            $response['data'] = [
                'conversationId' => $conversation->getConversationId(),
                'messages' => $this->prepareMessages($conversation->getMessages())
            ];
        }

        return $this->json($response);
    }

    /**
     * @param $messages
     * @return array
     */
    private function prepareMessages($messages): array
    {
        $messagesArray = [];
        /** @var AdminMessage $message */
        foreach($messages as $message) {
            $messagesArray[] = [
                'id' => $message->getMessageId(),
                'user' => $message->getUser()->getShortName(),
                'content' => $message->getMessage()
            ];
        }
        return $messagesArray;
    }
}