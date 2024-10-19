<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Adminhtml\Index;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use ProgramCms\UserBundle\Repository\Group\UserGroupRepository;

/**
 * Class SaveController
 * @package ProgramCms\UserBundle\Controller\Adminhtml\Index
 */
class SaveController extends AdminController
{
    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userEntityRepository;

    /**
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * @var UserGroupRepository
     */
    protected UserGroupRepository $groupRepository;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param UserEntityRepository $userEntityRepository
     * @param Url $url
     * @param ObjectSerializer $objectSerializer
     * @param UserGroupRepository $groupRepository
     */
    public function __construct(
        Context $context,
        UserEntityRepository $userEntityRepository,
        Url $url,
        ObjectSerializer $objectSerializer,
        UserGroupRepository $groupRepository
    )
    {
        parent::__construct($context);
        $this->url = $url;
        $this->userEntityRepository = $userEntityRepository;
        $this->objectSerializer = $objectSerializer;
        $this->groupRepository = $groupRepository;
    }

    /**
     * @return RedirectResponse
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if ($request->isMethod('POST')) {
            $userId = $this->getRequest()->getParam('entity_id');
            /** @var UserEntity $user */
            $user = $this->userEntityRepository->getById($userId) ?? new UserEntity();
            // Populate User Entity
            $postData = $request->request->all();
            $files = $request->files->all();
            $formData = array_merge($postData, $files);
            if(isset($formData['groups'])) {
                $formData['groups'] = explode(',', $formData['groups']);
            }
            unset($postData);
            unset($files);

            // Transform form data to user object
            $this->objectSerializer->arrayToObject($user, $formData, ['groups']);

            // Process User Groups
            if(isset($formData['groups'])) {
                $groups = [];
                foreach ($formData['groups'] as $groupCode) {
                    $group = $this->groupRepository->getByGroupCode($groupCode);
                    $groups[] = $group;
                }
                $user->setGroups($groups);
            }

            if (!$user) {
                $user->setCreatedAt();
            }
            $user->setUpdatedAt();

            // Add data for eav processing
            $user->addData($formData);

            // Save User
            $this->userEntityRepository->save($user);
            $this->addFlash('success', $this->trans('User successfully saved.'));
            return $this->redirect($this->url->getUrlByRouteName('user_index_edit', ['id' => $userId]));
        }
        return $this->redirect($this->url->getUrlByRouteName('user_index_index'));
    }
}