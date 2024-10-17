<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Controller\Adminhtml\Role;

use ProgramCms\AclBundle\Repository\RoleRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;

/**
 * Class EditController
 * @package ProgramCms\AclBundle\Controller\Adminhtml\Role
 */
class EditController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;

    /**
     * EditController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        RoleRepository $roleRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $roleId = $this->getRequest()->getParam('id');
        $role = $this->roleRepository->getById($roleId);
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->trans("Edit Role &mdash; " . $role->getRoleName())
        );
        return $pageResult;
    }
}