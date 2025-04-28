<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Security;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\UserBundle\Entity\UserEntity as User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\CacheableVoterInterface;

/**
 * Class CanDeletePostOnCategoryVoter
 * @package ProgramCms\PostBundle\Security
 */
class CanDeletePostOnCategoryVoter implements CacheableVoterInterface
{
    const CAN_DELETE_PERMISSION = 'ProgramCmsPostBundle_post_delete_categories';

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    private function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::CAN_DELETE_PERMISSION])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof CategoryEntity) {
            return false;
        }

        return true;
    }

    /**
     * @param TokenInterface $token
     * @param mixed $subject
     * @param array $attributes
     * @return int
     */
    public function vote(TokenInterface $token, mixed $subject, array $attributes)
    {
        $attribute = reset($attributes);
        if($this->supports($attribute, $subject) && $this->voteOnAttribute($attribute, $subject, $token)) {
            return self::ACCESS_GRANTED;
        }

        return self::ACCESS_DENIED;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var CategoryEntity $category */
        $category = $subject;

        return in_array($category->getEntityId(), explode(',', $user->getData('can_delete_posts_on_category')));
    }

    public function supportsAttribute(string $attribute): bool
    {
        return in_array($attribute, [self::CAN_DELETE_PERMISSION]);
    }

    public function supportsType(string $subjectType): bool
    {
        return true;
    }
}