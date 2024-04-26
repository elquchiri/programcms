<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Adminhtml\Index;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use ReflectionException;

/**
 * Class EditController
 * @package ProgramCms\UserBundle\Controller\Adminhtml\Index
 */
class EditController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * EditController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param UserEntityRepository $userRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        UserEntityRepository $userRepository,
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute()
    {
        $pageResult = $this->objectManager->create(Page::class);
        /** @var UserEntity $user */
        $user = $this->userRepository->findOneBy(['entity_id' => $this->getRequest()->getParam('id')]);
        if($user) {
            $pageResult->getConfig()->getTitle()->set($user->getFullName());
        }
        return $pageResult;
    }
}