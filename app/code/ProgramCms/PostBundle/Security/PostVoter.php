<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Security;

use ProgramCms\PostBundle\Entity\PostEntity as Post;
use ProgramCms\UserBundle\Entity\UserEntity as User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\CacheableVoterInterface;

/**
 * Class PostVoter
 * @package ProgramCms\PostBundle\Security
 */
class PostVoter implements CacheableVoterInterface
{
    const VIEW = 'view';
    const EDIT = 'edit';

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    private function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Post) {
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
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var Post $post */
        $post = $subject;

        return match($attribute) {
            self::VIEW => $this->canView($post, $user),
            self::EDIT => $this->canEdit($post, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    /**
     * @param Post $post
     * @param User $user
     * @return bool
     */
    private function canView(Post $post, User $user): bool
    {
        return true;
    }

    /**
     * @param Post $post
     * @param User $user
     * @return bool
     */
    private function canEdit(Post $post, User $user): bool
    {
        return $user === $post->getUser();
    }

    public function supportsAttribute(string $attribute): bool
    {
        return in_array($attribute, [self::VIEW, self::EDIT]);
    }

    public function supportsType(string $subjectType): bool
    {
        return true;
    }
}