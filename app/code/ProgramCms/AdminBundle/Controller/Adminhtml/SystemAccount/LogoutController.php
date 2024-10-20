<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Controller\Adminhtml\SystemAccount;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class LogoutController
 * @package ProgramCms\AdminBundle\Controller\Adminhtml\SystemAccount
 */
class LogoutController extends AdminController
{
    /**
     * @var Security
     */
    protected Security $security;
    /**
     * @var UrlGeneratorInterface
     */
    protected UrlGeneratorInterface $urlGenerator;

    /**
     * LogoutController constructor.
     * @param Context $context
     * @param Security $security
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        Context $context,
        Security $security,
        UrlGeneratorInterface $urlGenerator
    )
    {
        parent::__construct($context);
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @return RedirectResponse
     */
    public function execute()
    {
        // logout the admin user in on the current firewall
        $response = $this->security->logout();

        // controller can be blank: it will never be called!
        return new RedirectResponse($this->urlGenerator->generate('adminhtml_admin_index_index'));
    }
}