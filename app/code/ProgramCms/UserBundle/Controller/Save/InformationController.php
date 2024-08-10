<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Save;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class InformationController
 * @package ProgramCms\UserBundle\Controller\Save
 */
class InformationController extends Controller
{
    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * IndexController constructor.
     * @param Context $context
     * @param Security $security
     * @param UserEntityRepository $userRepository
     */
    public function __construct(
        Context $context,
        Security $security,
        UserEntityRepository $userRepository
    )
    {
        parent::__construct($context);
        $this->security = $security;
        $this->userRepository = $userRepository;
    }


    public function execute()
    {
        $firstname = $this->getRequest()->getParam('first_name');
        $lastname = $this->getRequest()->getParam('last_name');
        $email = $this->getRequest()->getParam('email');
        $username = $this->getRequest()->getParam('username');

        /** @var UserEntity $user */
        $user = $this->security->getUser();
        if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($username)) {
            $user
                ->setUserFirstname($firstname)
                ->setUserLastname($lastname)
                ->setEmail($email)
                ->setUsername($username);
            $this->userRepository->save($user);

            $this->addFlash('success',
                $this->translator->trans('Account Successfully Saved.')
            );
        }else{
            $this->addFlash('danger',
                $this->translator->trans('The provided informations are not valid, please try again.')
            );
        }

        return $this->redirect($this->url->getUrlByRouteName('user_edit_information'));
    }
}