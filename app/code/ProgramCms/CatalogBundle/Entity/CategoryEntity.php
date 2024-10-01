<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\EavBundle\Model\Entity\Entity;
use ProgramCms\EavBundle\Entity\EavAttributeSet;
use ProgramCms\PostBundle\Entity\PostEntity;

/**
 * Class Category
 * @package ProgramCms\CatalogBundle\Entity
 */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class CategoryEntity extends Entity
{
    /**
     * @var EavAttributeSet|null
     */
    #[ORM\ManyToOne(targetEntity: EavAttributeSet::class)]
    #[ORM\JoinColumn(name: 'attribute_set', referencedColumnName: 'attribute_set_id', nullable: true)]
    private ?EavAttributeSet $attribute_set = null;

    /**
     * @var CategoryEntity|null
     */
    #[ORM\ManyToOne(targetEntity: CategoryEntity::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent', referencedColumnName: 'entity_id', nullable: true)]
    private ?CategoryEntity $parent = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: CategoryEntity::class)]
    protected Collection $children;

    /**
     * @var Collection
     */
    #[ORM\JoinTable(name: 'category_post_relation')]
    #[ORM\ManyToMany(targetEntity: PostEntity::class, inversedBy: 'categories', cascade: ["persist"])]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'entity_id')]
    #[ORM\InverseJoinColumn(name: 'post_id', referencedColumnName: 'entity_id')]
    protected Collection $posts;

    /**
     * CategoryEntity constructor.
     * @param array $data
     */
    public function __construct(
        array $data = []
    )
    {
        parent::__construct($data);
        $this->children = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    /**
     * @return CategoryEntity|null
     */
    public function getParent(): ?CategoryEntity
    {
        return $this->parent;
    }

    /**
     * @param CategoryEntity $category
     * @return $this
     */
    public function setParent(CategoryEntity $category): static
    {
        $this->parent = $category;
        return $this;
    }

    /**
     * @return EavAttributeSet
     */
    public function getAttributeSet(): EavAttributeSet
    {
        return $this->attribute_set;
    }

    /**
     * @param EavAttributeSet $attributeSet
     * @return $this
     */
    public function setAttributeSet(EavAttributeSet $attributeSet): static
    {
        $this->attribute_set = $attributeSet;
        return $this;
    }

    /**
     * @return Collection<CategoryEntity>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return !$this->children->isEmpty();
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * @param ArrayCollection $posts
     * @return $this
     */
    public function setPosts(ArrayCollection $posts): static
    {
        $this->posts = $posts;
        return $this;
    }

    /**
     * @param PostEntity $post
     * @return $this
     */
    public function addPost(PostEntity $post): static
    {
        if(!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->addCategory($this);
        }

        return $this;
    }

    /**
     * @param PostEntity $post
     * @return $this
     */
    public function removePost(PostEntity $post): static
    {
        $this->posts->removeElement($post);
        return $this;
    }

    /**
     * @return PostEntity|null
     */
    public function getLastPost()
    {
        return $this->posts->last();
    }
}
