<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Controller\Adminhtml\Index;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class IndexController
 * @package ProgramCms\AdminBundle\Controller\Adminhtml\Index
 */
class IndexController extends \ProgramCms\CoreBundle\Controller\AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var AuthenticationUtils
     */
    protected AuthenticationUtils $authenticationUtils;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        AuthenticationUtils $authenticationUtils
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();

        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set("ProgramCMS Admin Panel");

        if($error) {
            $lastEmail = $this->authenticationUtils->getLastUsername();
            $pageResult->getLayout()->getBlock('admin.login')->setData('error', $error->getMessage());
            $pageResult->getLayout()->getBlock('admin.login')->setData('lastEmail', $lastEmail);
        }
        return $pageResult;
    }
}