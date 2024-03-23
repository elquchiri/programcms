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
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class VerifyTokenController
 * @package ProgramCms\UserBundle\Controller\Recovery
 */
class VerifyTokenController extends Controller
{
    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userEntityRepository;

    /**
     * VerifyToken constructor.
     * @param Context $context
     * @param UserEntityRepository $userEntityRepository
     */
    public function __construct(
        Context $context,
        UserEntityRepository $userEntityRepository
    )
    {
        parent::__construct($context);
        $this->userEntityRepository = $userEntityRepository;
    }

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        if($this->getRequest()->getCurrentRequest()->isMethod('POST')) {
            $token = $this->getRequest()->getParam('token');
            if(empty($token)) {
                return $this->json([
                    'success' => false,
                    'message' => $this->trans('Invalid Token Provided.')
                ]);
            }

            $user = $this->userEntityRepository->getByResetToken($token);
            if(!$user) {
                return $this->json([
                    'success' => false,
                    'message' => $this->trans('Invalid Token Provided.')
                ]);
            }

            return $this->json([
                'success' => true,
                'message' => $this->trans('Your identity has been verified successfully, hello %s, Please choose a new password', $user->getUserFirstname())
            ]);
        }

        return $this->json([
            'success' => false
        ]);
    }
}