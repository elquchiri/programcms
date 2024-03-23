<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Recovery;

use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Controller\Controller;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UpdatePasswordController
 * @package ProgramCms\UserBundle\Controller\Recovery
 */
class UpdatePasswordController extends Controller
{
    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userEntityRepository;

    /**
     * @var UserPasswordHasherInterface
     */
    protected UserPasswordHasherInterface $userPasswordHasher;

    /**
     * VerifyToken constructor.
     * @param Context $context
     * @param UserEntityRepository $userEntityRepository
     * @param UserPasswordHasherInterface $userPasswordHasher
     */
    public function __construct(
        Context $context,
        UserEntityRepository $userEntityRepository,
        UserPasswordHasherInterface $userPasswordHasher
    )
    {
        parent::__construct($context);
        $this->userEntityRepository = $userEntityRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function execute()
    {
        if($this->getRequest()->getCurrentRequest()->isMethod('POST')) {
            $token = $this->getRequest()->getParam('token');
            $password = $this->getRequest()->getParam('password');
            $checkPassword = $this->getRequest()->getParam('check_password');

            if(empty($token)) {
                return $this->json([
                    'success' => false,
                    'message' => $this->trans('Invalid Token Provided.')
                ]);
            }
            if(empty($password) || empty($checkPassword) || $password !== $checkPassword) {
                return $this->json([
                    'success' => false,
                    'message' => $this->trans('Please verify your password.')
                ]);
            }

            /** @var UserEntity $user */
            $user = $this->userEntityRepository->getByResetToken($token);
            if(!$user) {
                return $this->json([
                    'success' => false,
                    'message' => $this->trans('Invalid Token Provided.')
                ]);
            }

            // Update and save password
            $user
                ->setPassword($this->userPasswordHasher->hashPassword($user, $password))
                ->setResetToken('');
            $this->userEntityRepository->save($user);

            $this->addFlash('success', $this->trans('Your password has been changed successfully.'));
            return $this->json([
                'success' => true
            ]);
        }

        return $this->json([
            'success' => false
        ]);
    }
}