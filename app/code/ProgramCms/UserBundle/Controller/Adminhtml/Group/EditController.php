<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Adminhtml\Group;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\UserBundle\Entity\Group\UserGroup;
use ProgramCms\UserBundle\Repository\Group\UserGroupRepository;
use ReflectionException;

/**
 * Class EditController
 * @package ProgramCms\UserBundle\Controller\Group
 */
class EditController extends AdminController
{

    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var UserGroupRepository
     */
    protected UserGroupRepository $userGroupRepository;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param UserGroupRepository $userGroupRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        UserGroupRepository $userGroupRepository
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->userGroupRepository = $userGroupRepository;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var UserGroup $userGroup */
        $userGroup = $this->userGroupRepository->getById($id);
        $pageResult = $this->objectManager->create(Page::class);
        if($userGroup) {
            $pageResult->getConfig()->getTitle()->set(
                $this->trans("Group %s", $userGroup->getLabel())
            );
        }
        return $pageResult;
    }
}