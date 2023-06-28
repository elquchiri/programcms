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

    private $authenticationUtils;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        \ProgramCms\RouterBundle\Service\Response $response,
        AuthenticationUtils $authenticationUtils,
    )
    {
        parent::__construct($request, $response);
        $this->authenticationUtils = $authenticationUtils;
    }

    public function execute()
    {
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();

        $lastEmail = $this->authenticationUtils->getLastUsername();

        return $this->getResponse()->render();
    }
}