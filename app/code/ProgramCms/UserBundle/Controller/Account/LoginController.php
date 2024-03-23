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
use ReflectionException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class LoginController
 * @package ProgramCms\UserBundle\Controller\Account
 */
class LoginController extends \ProgramCms\CoreBundle\Controller\Controller
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * @var AuthenticationUtils
     */
    private AuthenticationUtils $authenticationUtils;

    /**
     * LoginController constructor.
     * @param Context $context
     * @param AuthenticationUtils $authenticationUtils
     * @param ObjectManager $objectManager
     * @param ValidatorInterface $validator
     */
    public function __construct(
        Context $context,
        AuthenticationUtils $authenticationUtils,
        ObjectManager $objectManager,
        ValidatorInterface $validator
    )
    {
        parent::__construct($context);
        $this->authenticationUtils = $authenticationUtils;
        $this->objectManager = $objectManager;
        $this->validator = $validator;
    }

    /**
     * @return object|null
     * @throws ReflectionException
     */
    public function execute()
    {
        if($this->getSecurity()->getUser()) {
            return $this->redirect($this->url->getUrlByRouteName('cms_index_index'));
        }

        $pageResult = $this->objectManager->create(\ProgramCms\CoreBundle\View\Result\Page::class);
        $pageResult->getConfig()->getTitle()->set(
            $this->trans("Authentication")
        );

        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();
        if($error) {
            $this->addFlash('danger', $this->trans($error->getMessage()));
            $lastEmail = $this->authenticationUtils->getLastUsername();
            $pageResult->getLayout()->getBlock('user.login.form')->setData('last_email', $lastEmail);
        }

        return $pageResult;
    }
}