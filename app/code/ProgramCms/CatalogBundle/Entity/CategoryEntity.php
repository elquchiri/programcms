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
     * CategoryEntity constructor.
     * @param array $data
     */
    public function __construct(
        array $data = []
    )
    {
        parent::__construct($data);
        $this->children = new ArrayCollection();
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
}
