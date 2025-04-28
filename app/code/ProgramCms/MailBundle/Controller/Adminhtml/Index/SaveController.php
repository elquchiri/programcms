<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\MailBundle\Controller\Adminhtml\Index;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminBundle\Repository\AdminUserRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\MailBundle\Entity\EmailTemplate;
use ProgramCms\MailBundle\Repository\EmailTemplateRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SaveController
 * @package ProgramCms\MailBundle\Controller\Adminhtml\Index
 */
class SaveController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var AdminUserRepository
     */
    protected AdminUserRepository $adminUserRepository;

    /**
     * @var EmailTemplateRepository
     */
    protected EmailTemplateRepository $emailTemplateRepository;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param EmailTemplateRepository $emailTemplateRepository
     * @param AdminUserRepository $adminUserRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        EmailTemplateRepository $emailTemplateRepository,
        AdminUserRepository $adminUserRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->adminUserRepository = $adminUserRepository;
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        $templateId = $this->getRequest()->getParam('entity_id');
        $editorJson = $this->getRequest()->getParam('data');
        $title = $this->getRequest()->getParam('title');
        $html = $this->getRequest()->getParam('html');
        $css = $this->getRequest()->getParam('css');

        if(empty($title)) {
            return $this->json([
                'success' => false,
                'message' => $this->trans('Please give a title to the Template.')
            ]);
        }

        if(!is_null($templateId) && !empty($templateId)) {
            /** @var EmailTemplate $emailTemplate */
            $emailTemplate = $this->emailTemplateRepository->getById($templateId);
        }else{
            /** @var AdminUser $user */
            $emailTemplate = new EmailTemplate();
        }

        $emailTemplate
            ->setCode($title)
            ->setName($title)
            ->setSubject('')
            ->setContent($editorJson)
            ->setHtml($html)
            ->setCss($css)
            ->setText('')
            ->updateTimestamps();

        // Save Page
        $this->emailTemplateRepository->save($emailTemplate);

        $this->addFlash('success', $this->trans('Email Template successfully saved.'));

        return $this->json([
            'success' => true,
            'redirect_url' => $this->getUrl()->getUrl('mailer_index_index')
        ]);
    }
}