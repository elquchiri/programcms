<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Account;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class LogoutController
 * @package ProgramCms\UserBundle\Controller\Account
 */
class LogoutController extends Controller
{
    /**
     * @var UrlGeneratorInterface
     */
    protected UrlGeneratorInterface $urlGenerator;

    /**
     * LogoutController constructor.
     * @param Context $context
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        Context $context,
        UrlGeneratorInterface $urlGenerator
    )
    {
        parent::__construct($context);
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return RedirectResponse
     */
    public function execute()
    {
        // logout the user in on the current firewall
        $response = $this->getSecurity()->logout();

        // controller can be blank: it will never be called!
        return new RedirectResponse($this->urlGenerator->generate('frontend_cms_index_index'));
    }
}