<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\EavBundle\Entity\EavAttributeSet;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\PostBundle\Api\PostInterface;
use ProgramCms\PostBundle\Repository\PostRepository;
use ProgramCms\UserBundle\Entity\UserEntity;

/**
 * Class PostEntity
 * @package ProgramCms\PostBundle\Entity
 */
#[ORM\Entity(repositoryClass: PostRepository::class)]
class PostEntity extends Entity implements PostInterface
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
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: CategoryEntity::class, mappedBy: 'posts', cascade: ["persist"])]
    private Collection $categories;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class)]
    private Collection $comments;

    /**
     * PostEntity constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->categories = new ArrayCollection();
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

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param ArrayCollection $categories
     * @return $this
     */
    public function setCategories(ArrayCollection $categories): static
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @param CategoryEntity $category
     * @return $this
     */
    public function addCategory(CategoryEntity $category): static
    {
        if(!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addPost($this);
        }
        return $this;
    }

    /**
     * @param CategoryEntity $category
     * @return $this
     */
    public function removeCategory(CategoryEntity $category): static
    {
        $this->categories->removeElement($category);
        return $this;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment): static
    {
        if(!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
        }
        return $this;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function removeComment(Comment $comment): static
    {
        $this->comments->removeElement($comment);
        return $this;
    }

    /**
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * @return Comment|bool
     */
    public function getLastComment(): Comment|bool
    {
        return $this->comments->last();
    }
}
