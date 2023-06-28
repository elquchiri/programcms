<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Account;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AuthenticationController
 * @package ProgramCms\UserBundle\Controller\Account
 */
class AuthenticationController extends \ProgramCms\CoreBundle\Controller\Controller
{

    protected \ProgramCms\CoreBundle\Model\ObjectManager $objectManager;
    private $authenticationUtils;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response,
        AuthenticationUtils $authenticationUtils,
        \ProgramCms\CoreBundle\Model\ObjectManager $objectManager
    )
    {
        parent::__construct($request, $response);
        $this->authenticationUtils = $authenticationUtils;
        $this->objectManager = $objectManager;
    }

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