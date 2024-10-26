<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Controller\Adminhtml\Index;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\View\Result\Page;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use ReflectionException;

/**
 * Class IndexController
 * @package ProgramCms\AdminBundle\Controller\Adminhtml\Index
 */
class IndexController extends AdminController
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
     * @var Url
     */
    protected Url $url;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param AuthenticationUtils $authenticationUtils
     * @param Url $url
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        AuthenticationUtils $authenticationUtils,
        Url $url
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->authenticationUtils = $authenticationUtils;
        $this->url = $url;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute()
    {
        // Redirect to dashboard if user already connected.
        if($this->getUser()) {
            return $this->redirect(
                $this->url->getUrlByRouteName('admin_dashboard_index')
            );
        }
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();

        /** @var Page $pageResult */
        $pageResult = $this->objectManager->create(Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->trans("ProgramCMS Admin Panel")
        );

        if($error) {
            $lastEmail = $this->authenticationUtils->getLastUsername();
            $pageResult->getLayout()->getBlock('admin.login')->setData('error', $error->getMessage());
            $pageResult->getLayout()->getBlock('admin.login')->setData('lastEmail', $lastEmail);
        }
        return $pageResult;
    }
}