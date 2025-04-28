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
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use ProgramCms\UserBundle\Security\LoginAuthenticator;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

/**
 * Class LoginAsUserController
 * @package ProgramCms\UserBundle\Controller\Account
 */
class LoginAsUserController extends Controller
{
    /**
     * @var LoginAuthenticator
     */
    protected LoginAuthenticator $loginAuthenticator;

    /**
     * @var UserAuthenticatorInterface
     */
    protected UserAuthenticatorInterface $userAuthenticator;

    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * LoginAsUserController constructor.
     * @param Context $context
     * @param LoginAuthenticator $loginAuthenticator
     * @param UserAuthenticatorInterface $userAuthenticator
     * @param UserEntityRepository $userRepository
     */
    public function __construct(
        Context $context,
        LoginAuthenticator $loginAuthenticator,
        UserAuthenticatorInterface $userAuthenticator,
        UserEntityRepository $userRepository
    )
    {
        parent::__construct($context);
        $this->loginAuthenticator = $loginAuthenticator;
        $this->userAuthenticator = $userAuthenticator;
        $this->userRepository = $userRepository;
    }

    public function execute()
    {
        $userId = $this->getRequest()->getParam('id');
        if(!empty($userId)) {
            /** @var UserEntity $user */
            $user = $this->userRepository->getById($userId);
            if($user) {
                $this->userAuthenticator->authenticateUser(
                    $user,
                    $this->loginAuthenticator,
                    $this->getRequest()->getCurrentRequest()
                );
            }
        }

        return $this->redirect($this->getUrl()->getUrlByRouteName('cms_index_index'));
    }
}