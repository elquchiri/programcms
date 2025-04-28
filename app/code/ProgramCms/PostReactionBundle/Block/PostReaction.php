<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostReactionBundle\Block;

use Doctrine\Common\Collections\ArrayCollection;
use ProgramCms\PostBundle\Block\Post;
use ProgramCms\PostReactionBundle\Entity\PostReaction as PostReactionEntity;

/**
 * Class PostReaction
 * @package ProgramCms\PostReactionBundle\Block
 */
class PostReaction extends Post
{
    /**
     * @return string
     */
    public function getLikesResume(): string
    {
        $reactions = new ArrayCollection($this->getPost()->getReactions()->toArray());
        $reactionsCount = $reactions->count();
        $user = $this->getUser();

        if($reactions->isEmpty()) {
            return '';
        }

        $filteredReactions = $reactions->filter(function (PostReactionEntity $reaction) use ($user) {
            return $reaction->getUser() === $user;
        });

        /** @var PostReactionEntity $firstReaction */
        $firstReaction = $reactions->first();
        $first = !$filteredReactions->isEmpty() ? 'You' : "<a href='#'>{$firstReaction->getUser()->getUserFirstname()}</a>";
        if(!$filteredReactions->isEmpty()) {
            $reactions->removeElement($filteredReactions->first());
        }
        $second = "";

        if($reactionsCount === 1) {
            return $this->trans('%s like this post', $first);
        }

        if($reactions->count() >= 1) {
            /** @var PostReactionEntity $secondReaction */
            $secondReaction = $reactions->get(1);
            $second = "<a href='#'>{$secondReaction->getUser()->getUserFirstname()}</a>";
            if($reactionsCount < 3) {
                return $this->trans('%s and %s likes this post', $first, $second);
            }
        }

        if($reactionsCount > 2) {
            $third = $reactionsCount - 2;
            return $this->trans('%s, %s and %s others liked this post.', $first, $second, $third);
        }

        return '';
    }

    public function getCurrentReaction()
    {
        /** @var ArrayCollection<PostReactionEntity> $reactions */
        $reactions = $this->getPost()->getReactions();
        $post = $this->getPost();
        $user = $this->getUser();
        if(!empty($reactions)) {
            $filteredReactions = $reactions->filter(function (PostReactionEntity $reaction) use ($user, $post) {
                return $reaction->getUser() === $user && $reaction->getPost() === $post;
            });

            if (!$filteredReactions->isEmpty()) {
                /** @var PostReactionEntity $reaction */
                $reaction = $filteredReactions->first();
                return $reaction->getReactionType()->value;
            }
        }

        return false;
    }
}