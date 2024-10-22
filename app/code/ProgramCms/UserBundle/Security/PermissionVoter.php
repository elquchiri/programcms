<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Security;

use ProgramCms\UserBundle\Entity\Group\UserGroup;
use ProgramCms\UserBundle\Entity\Group\UserGroupPermission;
use ProgramCms\UserBundle\Entity\UserEntity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\CacheableVoterInterface;
use ProgramCms\RouterBundle\Service\Request;

/**
 * Class PermissionVoter
 * @package ProgramCms\UserBundle\Security
 */
class PermissionVoter implements CacheableVoterInterface
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * PermissionVoter constructor.
     * @param Request $request
     */
    public function __construct(
        Request $request
    )
    {
        $this->request = $request;
    }

    /**
     * @param TokenInterface $token
     * @param mixed $subject
     * @param array $attributes
     * @return bool
     */
    public function vote(TokenInterface $token, mixed $subject, array $attributes)
    {
        $attribute = reset($attributes);
        /** @var UserEntity $user */
        $user = $token->getUser();
        if(!$user) {
            return false;
        }

        $groups = $user->getCollectionGroups();
        /** @var UserGroup $group */
        foreach($groups as $group) {
            /** @var UserGroupPermission $permission */
            foreach($group->getPermissions() as $permission) {
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
        if($this->request->getCurrentAreaCode() == 'frontend') {
            return true;
        }

        return false;
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