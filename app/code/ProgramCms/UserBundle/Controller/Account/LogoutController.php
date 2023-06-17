<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Account;


use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LogoutController extends \ProgramCms\CoreBundle\Controller\Adminhtml\AbstractController
{

    private Security $security;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(
        \ProgramCms\RouterBundle\Service\Request $request,
        Security $security,
        UrlGeneratorInterface $urlGenerator
    )
    {
        parent::__construct($request);
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    public function execute()
    {
        // logout the user in on the current firewall
        $response = $this->security->logout();

        // controller can be blank: it will never be called!
        return new RedirectResponse($this->urlGenerator->generate('frontend_home'));
    }
}