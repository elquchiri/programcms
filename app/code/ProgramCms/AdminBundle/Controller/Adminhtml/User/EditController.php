<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Controller\Adminhtml\User;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminBundle\Repository\AdminUserRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class EditController
 * @package ProgramCms\AdminBundle\Controller\Adminhtml\User
 */
class EditController extends AdminController
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
     * EditController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param AdminUserRepository $adminUserRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        AdminUserRepository $adminUserRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $pageResult = $this->objectManager->create(Page::class);
        if($this->getRequest()->hasParam('id')) {
            $id = $this->getRequest()->getParam('id');
            /** @var AdminUser $user */
            $user = $this->adminUserRepository->getById($id);
            $userFullName = !empty($user->getFullName()) ? $user->getFullName() : $user->getUserIdentifier();
            $pageResult->getConfig()->getTitle()->set($userFullName);
        }
        return $pageResult;
    }
}