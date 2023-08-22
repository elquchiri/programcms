<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Account;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AuthenticationController
 * @package ProgramCms\UserBundle\Controller\Account
 */
class AuthenticationController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var AuthenticationUtils
     */
    private AuthenticationUtils $authenticationUtils;

    /**
     * AuthenticationController constructor.
     * @param Context $context
     * @param AuthenticationUtils $authenticationUtils
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Context $context,
        AuthenticationUtils $authenticationUtils,
        ObjectManager $objectManager
    )
    {
        parent::__construct($context);
        $this->authenticationUtils = $authenticationUtils;
        $this->objectManager = $objectManager;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastEmail = $this->authenticationUtils->getLastUsername();
        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);

        $pageResult->getConfig()->getTitle()->set("Authentication");
        return $pageResult;
    }
}