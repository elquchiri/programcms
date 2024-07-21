<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Entity;

use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use ProgramCms\PostBundle\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use ProgramCms\UserBundle\Entity\UserEntity;

/**
 * Class Comment
 * @package ProgramCms\PostBundle\Entity
 */
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment extends Entity
{
    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'entity_id')]
    private ?UserEntity $user;

    #[ORM\ManyToOne(targetEntity: PostEntity::class)]
    #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'entity_id')]
    private ?PostEntity $post;

    #[ORM\Column(type: 'text')]
    private string $comment;

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
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
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
     * @return PostEntity
     */
    public function getPost(): PostEntity
    {
        return $this->post;
    }

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment(string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }
}