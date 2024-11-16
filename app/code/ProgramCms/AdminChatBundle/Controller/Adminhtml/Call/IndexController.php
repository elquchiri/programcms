<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Controller\Adminhtml\Call;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminChatBundle\Entity\AdminConversation;
use ProgramCms\AdminChatBundle\Helper\ConversationHelper;
use ProgramCms\AdminChatBundle\Repository\AdminConversationRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;

/**
 * Class IndexController
 * @package ProgramCms\AdminChatBundle\Controller\Adminhtml\Call
 */
class IndexController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var AdminConversationRepository
     */
    protected AdminConversationRepository $conversationRepository;

    /**
     * @var ConversationHelper
     */
    protected ConversationHelper $conversationHelper;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param AdminConversationRepository $conversationRepository
     * @param ConversationHelper $conversationHelper
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        AdminConversationRepository $conversationRepository,
        ConversationHelper $conversationHelper
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->conversationRepository = $conversationRepository;
        $this->conversationHelper = $conversationHelper;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $conversationId = $this->getRequest()->getParam('id');
        if(empty($conversationId)) {
            return $this->redirect($this->getUrl()->getUrlByRouteName('admin_dashboard_index'));
        }
        /** @var AdminConversation $conversation */
        $conversation = $this->conversationRepository->getById($conversationId);
        if(!$conversation) {
            return $this->redirect($this->getUrl()->getUrlByRouteName('admin_dashboard_index'));
        }

        if(!in_array($this->getUser(), $conversation->getUsers()->toArray())) {
            return $this->redirect($this->getUrl()->getUrlByRouteName('admin_dashboard_index'));
        }

        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->trans("Call - " . $this->conversationHelper->formatConversationUsers($conversation))
        );
        return $pageResult;
    }
}