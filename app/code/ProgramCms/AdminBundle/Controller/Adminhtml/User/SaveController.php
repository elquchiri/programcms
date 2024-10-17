<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Controller\Adminhtml\User;

use ProgramCms\AclBundle\Repository\RoleRepository;
use ProgramCms\AdminBundle\Entity\AdminUser;
use ProgramCms\AdminBundle\Repository\AdminUserRepository;
use ProgramCms\CoreBundle\Controller\AdminController;
use ProgramCms\CoreBundle\Controller\Context;
use ProgramCms\CoreBundle\Serialize\Serializer\ObjectSerializer;
use ProgramCms\RouterBundle\Service\Url;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class SaveController
 * @package ProgramCms\AdminBundle\Controller\Adminhtml\User
 */
class SaveController extends AdminController
{
    /**
     * @var AdminUserRepository
     */
    protected AdminUserRepository $adminUserRepository;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var UserPasswordHasherInterface
     */
    protected UserPasswordHasherInterface $passwordHasher;

    /**
     * @var ObjectSerializer
     */
    protected ObjectSerializer $objectSerializer;

    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;

    /**
     * SaveController constructor.
     * @param Context $context
     * @param AdminUserRepository $adminUserRepository
     * @param UserPasswordHasherInterface $passwordHasher
     * @param Url $url
     * @param ObjectSerializer $objectSerializer
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        Context $context,
        AdminUserRepository $adminUserRepository,
        UserPasswordHasherInterface $passwordHasher,
        Url $url,
        ObjectSerializer $objectSerializer,
        RoleRepository $roleRepository
    )
    {
        parent::__construct($context);
        $this->adminUserRepository = $adminUserRepository;
        $this->url = $url;
        $this->passwordHasher = $passwordHasher;
        $this->objectSerializer = $objectSerializer;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return object|null
     */
    public function execute()
    {
        $request = $this->getRequest()->getCurrentRequest();
        if ($request->getMethod() == 'POST') {
            $formData = $request->request->all();
            if(isset($formData['user_id'])) {
                $id = $formData['user_id'];
                $user = $this->adminUserRepository->getById($id);
            }else{
                $user = new AdminUser();
            }

            if (!$this->passwordHasher->isPasswordValid($this->security->getUser(), $formData['password'])) {
                // Flash error message and redirect
                $this->addFlash('danger',
                    $this->trans('The provided password is not valid, please try again.')
                );
                return $this->redirect($this->url->getUrlByRouteName('admin_user_edit', ['id' => $user->getEntityId()]));
            }

            $user
                ->setFirstName($formData['first_name'])
                ->setLastName($formData['last_name'])
                ->setEmail($formData['email'])
                ->setInterfaceLocale($formData['interface_locale']);

            if(isset($formData['roles'])) {
                $formData['roles'] = explode(',', $formData['roles']);
                $roles = [];
                foreach ($formData['roles'] as $roleCode) {
                    $role = $this->roleRepository->getByRoleCode($roleCode);
                    $roles[] = $role;
                }
                $user->setRoles($roles);
            }

            // Update Password
            if(isset($formData['new_password']) && !empty($formData['new_password'])) {
                if(isset($formData['password_confirmation']) && !empty($formData['password_confirmation'])) {
                    if($formData['new_password'] !== $formData['password_confirmation']) {
                        $this->addFlash('danger',
                            $this->trans('The passwords you entered do not match. Please make sure both passwords are identical before submitting.')
                        );
                        return $this->redirect($this->url->getUrlByRouteName('admin_user_edit', ['id' => $user->getEntityId()]));
                    }
                    $user
                        ->setPassword($this->passwordHasher->hashPassword($user, $formData['new_password']))
                        ->setResetToken('');
                }
            }

            // Save User Data
            $this->adminUserRepository->save($user);
            // Flash success message and redirect
            $this->addFlash('success',
                $this->translator->trans('Account Successfully Saved.')
            );
            return $this->redirect($this->url->getUrlByRouteName('admin_user_edit', ['id' => $user->getEntityId()]));
        }
        return $this->redirect($this->url->getUrlByRouteName('admin_user_index'));
    }
}