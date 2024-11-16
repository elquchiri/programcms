<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Controller\Adminhtml\Api;

use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminBundle\Repository\AdminUserRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class SearchController
 * @package ProgramCms\AdminChatBundle\Controller\Adminhtml\Api
 */
class SearchController extends AdminController
{
    /**
     * @var AdminUserRepository
     */
    protected AdminUserRepository $userRepository;

    /**
     * SearchController constructor.
     * @param Context $context
     * @param AdminUserRepository $userRepository
     */
    public function __construct(
        Context $context,
        AdminUserRepository $userRepository
    )
    {
        parent::__construct($context);
        $this->userRepository = $userRepository;
    }

    /**
     * @return JsonResponse
     */
    public function execute()
    {
        $response = ['success' => false, 'data' => []];
        $qWord = $this->getRequest()->getParam('qWord');

        if(empty($qWord)) {
            $response['success'] = false;
            return $this->json($response);
        }

        $users = $this->userRepository->findByKeyword($qWord);
        /** @var AdminUser $user */
        foreach($users as $user) {
            if($user->getUserId() === $this->getUser()->getUserId()) {
                continue;
            }
            $response['data'][] = [
                'id' => $user->getUserId(),
                'firstname' => $user->getFirstName(),
                'lastname' => $user->getLastName()
            ];
        }
        $response['success'] = true;
        return $this->json($response);
    }
}