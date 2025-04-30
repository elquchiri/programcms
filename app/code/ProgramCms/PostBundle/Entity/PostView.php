<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Entity;

use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use ProgramCms\PostBundle\Repository\PostViewRepository;
use ProgramCms\UserBundle\Entity\UserEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PostView
 * @package ProgramCms\PostBundle\Entity
 */
#[ORM\Entity(repositoryClass: PostViewRepository::class)]
class PostView extends Entity
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
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'entity_id', nullable: true)]
    private ?UserEntity $user;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $visitorSessionId = null;  // for anonymous visitors

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $ipAddress = null;

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
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return $this
     */
    public function setIpAddress(string $ipAddress): static
    {
        $this->ipAddress = $ipAddress;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVisitorSessionId(): ?string
    {
        return $this->visitorSessionId;
    }

    /**
     * @param string $visitorSessionId
     * @return $this
     */
    public function setVisitorSessionId(string $visitorSessionId): static
    {
        $this->visitorSessionId = $visitorSessionId;
        return $this;
    }
}