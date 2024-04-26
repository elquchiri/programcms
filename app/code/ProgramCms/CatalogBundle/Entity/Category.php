<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use ProgramCms\EavBundle\Entity\EavAttributeSet;

/**
 * Class Category
 * @package ProgramCms\CatalogBundle\Entity
 */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category extends Entity
{
    /**
     * @var EavAttributeSet|null
     */
    #[ORM\ManyToOne(targetEntity: EavAttributeSet::class)]
    #[ORM\JoinColumn(name: 'attribute_set', referencedColumnName: 'attribute_set_id', nullable: true)]
    private ?EavAttributeSet $attribute_set = null;

    /**
     * @var Category|null
     */
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent', referencedColumnName: 'entity_id', nullable: true)]
    private ?Category $parent = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Category::class)]
    protected Collection $children;

    /**
     * Category constructor.
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
     * @return Category|null
     */
    public function getParent(): ?Category
    {
        return $this->parent;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function setParent(Category $category): static
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
     * @return Collection
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }
}
