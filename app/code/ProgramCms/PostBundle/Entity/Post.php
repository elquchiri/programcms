<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\EavBundle\Entity\EavAttributeSet;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\PostBundle\Api\PostInterface;
use ProgramCms\PostBundle\Repository\PostRepository;
use ProgramCms\UserBundle\Entity\UserEntity;

/**
 * Class Post
 * @package ProgramCms\PostBundle\Entity
 */
#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post extends Entity implements PostInterface
{
    /**
     * @var EavAttributeSet|null
     */
    #[ORM\ManyToOne(targetEntity: EavAttributeSet::class)]
    #[ORM\JoinColumn(name: 'attribute_set_id', referencedColumnName: 'attribute_set_id', nullable: true)]
    private ?EavAttributeSet $attributeSet = null;

    /**
     * @var UserEntity|null
     */
    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'entity_id')]
    private ?UserEntity $user;

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
     * @return EavAttributeSet|null
     */
    public function getAttributeSet(): ?EavAttributeSet
    {
        return $this->attributeSet;
    }

    /**
     * @param EavAttributeSet $attributeSet
     * @return $this
     */
    public function setAttributeSet(EavAttributeSet $attributeSet): static
    {
        $this->attributeSet = $attributeSet;
        return $this;
    }
}
