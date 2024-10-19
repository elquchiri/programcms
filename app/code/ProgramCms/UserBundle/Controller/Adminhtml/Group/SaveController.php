<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Controller\Adminhtml\Group;

use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\UserBundle\Entity\Group\UserGroup;
use ProgramCms\UserBundle\Repository\Group\UserGroupRepository;

/**
 * Class SaveController
 * @package ProgramCms\UserBundle\Controller\Adminhtml\Group
 */
class SaveController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var UserGroupRepository
     */
    protected UserGroupRepository $groupRepository;

    /**
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param UserGroupRepository $groupRepository
     * @param ObjectSerializer $objectSerializer
     * @param Url $url
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        UserGroupRepository $groupRepository,
        ObjectSerializer $objectSerializer,
        Url $url
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->groupRepository = $groupRepository;
        $this->objectSerializer = $objectSerializer;
        $this->url = $url;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        $postData = $request->request->all();

        if ($request->isMethod('POST')) {
            // Prepare UserGroup entity
            if($this->getRequest()->hasParam('group_id')) {
                /** @var UserGroup $group */
                $group = $this->groupRepository->getById((int) $this->getRequest()->getParam('group_id'));
                $route = $this->url->getUrlByRouteName('user_group_edit', ['id' => $group->getGroupId()]);
            }else{
                $group = new UserGroup();
                $route = $this->url->getUrlByRouteName('user_group_new');
            }

            $this->objectSerializer->arrayToObject($group, $postData);
            unset($postData);

            $this->groupRepository->save($group);
            $this->addFlash('success', $this->trans('User Group successfully saved.'));
            return $this->redirect($this->url->getUrlByRouteName('user_group_edit', ['id' => $group->getGroupId()]));
        }

        return $this->redirect($this->url->getUrlByRouteName('user_group_index'));
    }
}