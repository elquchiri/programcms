<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\MailBundle\Controller\Adminhtml\Index;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\MailBundle\Repository\EmailTemplateRepository;
use ReflectionException;

/**
 * Class EditController
 * @package ProgramCms\MailBundle\Controller\Adminhtml\Index
 */
class EditController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var EmailTemplateRepository
     */
    protected EmailTemplateRepository $emailTemplateRepository;

    /**
     * EditController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param EmailTemplateRepository $emailTemplateRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        EmailTemplateRepository $emailTemplateRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    /**
     * @return object
     * @throws ReflectionException
     */
    public function execute(): object
    {
        $templateId = $this->getRequest()->getParam('id');
        $emailTemplate = $this->emailTemplateRepository->getById($templateId);
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set($emailTemplate->getName());
        return $pageResult;
    }
}