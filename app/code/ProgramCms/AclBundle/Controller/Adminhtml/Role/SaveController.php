<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Controller\Adminhtml\Role;

use ProgramCms\AclBundle\Entity\Role;
use ProgramCms\AclBundle\Repository\RoleRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class SaveController
 * @package ProgramCms\AclBundle\Controller\Adminhtml\Role
 */
class SaveController extends AdminController
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;

    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;

    /**
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var UserPasswordHasherInterface
     */
    protected UserPasswordHasherInterface $passwordHasher;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param ObjectManager $objectManager
     * @param RoleRepository $roleRepository
     * @param ObjectSerializer $objectSerializer
     * @param Url $url
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(
        Context $context,
        ObjectManager $objectManager,
        RoleRepository $roleRepository,
        ObjectSerializer $objectSerializer,
        Url $url,
        UserPasswordHasherInterface $passwordHasher
    )
    {
        parent::__construct($context);
        $this->objectManager = $objectManager;
        $this->roleRepository = $roleRepository;
        $this->objectSerializer = $objectSerializer;
        $this->url = $url;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        $postData = $request->request->all();

        if ($request->isMethod('POST')) {
            // Prepare Role entity
            if($this->getRequest()->hasParam('role_id')) {
                $role = $this->roleRepository->getById($this->getRequest()->getParam('role_id'));
                $route = $this->url->getUrlByRouteName('acl_role_edit', ['id' => $role->getRoleId()]);
            }else{
                $role = new Role();
                $route = $this->url->getUrlByRouteName('acl_role_new');
            }

            if (!$this->passwordHasher->isPasswordValid($this->security->getUser(), $postData['password'])) {
                // Flash error message and redirect
                $this->addFlash('danger',
                    $this->trans('The provided password is not valid, please try again.')
                );
                return $this->redirect($route);
            }

            $this->objectSerializer->arrayToObject($role, $postData);
            unset($postData);

            $this->roleRepository->save($role);
            $this->addFlash('success', $this->trans('Role successfully saved.'));
            return $this->redirect($this->url->getUrlByRouteName('acl_role_edit', ['id' => $role->getRoleId()]));
        }

        return $this->redirect($this->url->getUrlByRouteName('acl_role_index'));
    }
}