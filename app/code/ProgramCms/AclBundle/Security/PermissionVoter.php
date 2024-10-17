<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Security;

use ProgramCms\AclBundle\Entity\Permission;
use ProgramCms\AclBundle\Entity\Role;
use ProgramCms\AdminBundle\Entity\AdminUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\CacheableVoterInterface;

/**
 * Class PermissionVoter
 * @package ProgramCms\AclBundle\Security
 */
class PermissionVoter implements CacheableVoterInterface
{
    /**
     * @param TokenInterface $token
     * @param mixed $subject
     * @param array $attributes
     * @return bool
     */
    public function vote(TokenInterface $token, mixed $subject, array $attributes)
    {
        $attribute = reset($attributes);
        /** @var AdminUser $user */
        $user = $token->getUser();
        if(!$user) {
            return false;
        }

        $roles = $user->getCollectionRoles();
        /** @var Role $role */
        foreach($roles as $role) {
            /** @var Permission $permission */
            foreach($role->getPermissions() as $permission) {
                if($attribute == $permission->getResource()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param string $attribute
     * @return bool
     */
    public function supportsAttribute(string $attribute): bool
    {
        return true;
    }

    /**
     * @param string $subjectType
     * @return bool
     */
    public function supportsType(string $subjectType): bool
    {
        return true;
    }
}