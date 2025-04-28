<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostReactionBundle\Entity;

use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostReactionBundle\Enum\ReactionType;
use ProgramCms\PostReactionBundle\Repository\PostReactionRepository;
use ProgramCms\UserBundle\Entity\UserEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostReaction
 * @package ProgramCms\PostReactionBundle\Entity
 */
#[ORM\Entity(repositoryClass: PostReactionRepository::class)]
#[ORM\UniqueConstraint(columns: ['post_id', 'user_id'])]
class PostReaction extends Entity
{
    /**
     * @var PostEntity|null
     */
    #[ORM\ManyToOne(targetEntity: PostEntity::class)]
    #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'entity_id')]
    private ?PostEntity $post;

    /**
     * @var UserEntity|null
     */
    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'entity_id')]
    private ?UserEntity $user;

    /**
     * @var ReactionType
     */
    #[ORM\Column(enumType: ReactionType::class)]
    private ReactionType $reactionType;

    /**
     * @return PostEntity|null
     */
    public function getPost(): ?PostEntity
    {
        return $this->post;
    }

    /**
     * @param PostEntity $post
     * @return $this
     */
    public function setPost(PostEntity $post): static
    {
        $this->post = $post;
        return $this;
    }

    /**
     * @return UserEntity|null
     */
    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    /**
     * @param UserEntity $user
     * @return $this
     */
    public function setUser(UserEntity $user): static
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return ReactionType|null
     */
    public function getReactionType(): ?ReactionType
    {
        return $this->reactionType;
    }

    /**
     * @param ReactionType $reactionType
     * @return $this
     */
    public function setReactionType(ReactionType $reactionType): static
    {
        $this->reactionType = $reactionType;
        return $this;
    }
}