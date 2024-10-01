<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Profile;

use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use ReflectionException;

/**
 * Class ViewController
 * @package ProgramCms\UserBundle\Controller\Index
 */
class ViewController extends Controller
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
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param UserEntityRepository $userRepository
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        UserEntityRepository $userRepository
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
        $id = (int) $this->getRequest()->getParam('id');
        $user = $this->userRepository->getById($id);
        if(!$user) {
            // Redirect to home page
        }

        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $user->getFullName()
        );
        return $pageResult;
    }
}