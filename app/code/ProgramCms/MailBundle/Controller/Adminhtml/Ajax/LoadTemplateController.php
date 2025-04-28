<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\MailBundle\Controller\Adminhtml\Ajax;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\MailBundle\Entity\EmailTemplate;
use ProgramCms\MailBundle\Repository\EmailTemplateRepository;

/**
 * Class LoadTemplateController
 * @package ProgramCms\MailBundle\Controller\Adminhtml\Ajax
 */
class LoadTemplateController extends AdminController
{
    /**
     * @var EmailTemplateRepository
     */
    protected EmailTemplateRepository $emailTemplateRepository;

    /**
     * LoadTemplateController constructor.
     * @param Context $context
     * @param EmailTemplateRepository $emailTemplateRepository
     */
    public function __construct(
        Context $context,
        EmailTemplateRepository $emailTemplateRepository
    )
    {
        parent::__construct($context);
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    public function execute()
    {
        $templateId = $this->getRequest()->getParam('template_id');
        if(is_null($templateId) || empty($templateId)) {
            return $this->json([
                'edit' => false
            ]);
        }

        /** @var EmailTemplate $emailTemplate */
        $emailTemplate = $this->emailTemplateRepository->getById($templateId);
        return $this->json([
            'edit' => true,
            'title' => $emailTemplate->getName(),
            'data' => $emailTemplate->getContent()
        ]);
    }
}