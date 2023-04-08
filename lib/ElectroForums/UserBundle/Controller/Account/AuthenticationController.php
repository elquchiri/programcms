<?php
/*
 * Copyright © ElectroForums. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ElectroForums\UserBundle\Controller\Account;


use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends \ElectroForums\CoreBundle\Controller\Adminhtml\AbstractController
{

    private $authenticationUtils;

    public function __construct(
        \ElectroForums\RouterBundle\Service\Request $request,
        AuthenticationUtils $authenticationUtils,
    )
    {
        parent::__construct($request);
        $this->authenticationUtils = $authenticationUtils;
    }

    public function execute()
    {
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();

        $lastEmail = $this->authenticationUtils->getLastUsername();

        return $this->render('@ElectroForumsUser/frontend/authentication/login.html.twig', [
            'email' => $lastEmail,
            'error' => $error
        ]);
    }
}