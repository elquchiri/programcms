<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Controller\Adminhtml\Api;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminChatBundle\Entity\AdminConversation;
use ProgramCms\AdminChatBundle\Helper\ConversationHelper;
use ProgramCms\AdminChatBundle\Repository\AdminConversationRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\DateTime\TransformerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ConversationsController
 * @package ProgramCms\AdminChatBundle\Controller\Adminhtml\Api
 */
class ConversationsController extends AdminController
{
    /**
     * @var ConversationHelper
     */
    protected ConversationHelper $conversationHelper;

    /**
     * @var TransformerInterface
     */
    protected TransformerInterface $transformer;
    protected AdminConversationRepository $conversationRepository;

    /**
     * ConversationsController constructor.
     * @param Context $context
     * @param ConversationHelper $conversationHelper
     * @param TransformerInterface $transformer
     */
    public function __construct(
        Context $context,
        ConversationHelper $conversationHelper,
        TransformerInterface $transformer,
        AdminConversationRepository $conversationRepository
    )
    {
        parent::__construct($context);
        $this->conversationHelper = $conversationHelper;
        $this->transformer = $transformer;
        $this->conversationRepository = $conversationRepository;
    }

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        $response = ['success' => false, 'conversations' => []];
        /** @var AdminUser $user */
        $user = $this->getUser();
        $conversations = $this->conversationRepository->findUserConversationsOrderedByLastMessage($user);
        /** @var AdminConversation $conversation */
        foreach($conversations as $conversation) {
            $response['conversations'][] = [
                'id' => $conversation->getConversationId(),
                'title' => $this->conversationHelper->formatConversationUsers($conversation),
                'lastMessage' => $conversation->getMessages()->last() ? $conversation->getMessages()->last()->getMessage() : '',
                'updatedAt' => $conversation->getMessages()->last() ? $this->transformer->timeAgo($conversation->getMessages()->last()->getUpdatedAt()) : ''
            ];
        }
        $response['success'] = true;
        return $this->json($response);
    }
}