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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class PasswordController
 * @package ProgramCms\UserBundle\Controller\Save
 */
class PasswordController extends Controller
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
     * @var UserPasswordHasherInterface
     */
    protected UserPasswordHasherInterface $userPasswordHasher;

    /**
     * PasswordController constructor.
     * @param Context $context
     * @param Security $security
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param UserEntityRepository $userRepository
     */
    public function __construct(
        Context $context,
        Security $security,
        UserPasswordHasherInterface $userPasswordHasher,
        UserEntityRepository $userRepository
    )
    {
        parent::__construct($context);
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @return RedirectResponse
     */
    public function execute()
    {
        $newPassword = $this->getRequest()->getParam('new_password');
        $confirmedPassword = $this->getRequest()->getParam('confirm_password');
        $password = $this->getRequest()->getParam('password');

        /** @var UserEntity $user */
        $user = $this->security->getUser();

        if (empty($newPassword) || empty($confirmedPassword) || empty($password)) {
            $this->addFlash('danger',
                $this->translator->trans('The provided informations are not valid, please try again.')
            );
            return $this->redirect($this->url->getUrlByRouteName('user_edit_password'));
        }

        if($newPassword != $confirmedPassword) {
            $this->addFlash('danger',
                $this->translator->trans('The provided passwords are not equal, please try again.')
            );
            return $this->redirect($this->url->getUrlByRouteName('user_edit_password'));
        }

        if(!$this->userPasswordHasher->isPasswordValid($user, $password)) {
            $this->addFlash('danger',
                $this->translator->trans('The current password is not valid, please try again.')
            );
            return $this->redirect($this->url->getUrlByRouteName('user_edit_password'));
        }

        $user
            ->setPassword($this->userPasswordHasher->hashPassword($user, $newPassword))
            ->setResetToken('');
        $this->userRepository->save($user);

        $this->addFlash('success',
            $this->translator->trans('Password Successfully updated.')
        );

        return $this->redirect($this->url->getUrlByRouteName('user_edit_password'));
    }
}