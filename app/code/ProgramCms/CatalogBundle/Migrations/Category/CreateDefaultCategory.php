<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Migrations\Category;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\DataPatchBundle\Model\DataPatchInterface;
use ProgramCms\EavBundle\Entity\EavAttributeSet;
use ProgramCms\EavBundle\Repository\EavAttributeSetRepository;
use ProgramCms\EavBundle\Repository\EavEntityTypeRepository;

/**
 * Class CreateDefaultCategory
 * @package ProgramCms\CatalogBundle\Migrations\Category
 */
class CreateDefaultCategory implements DataPatchInterface
{
    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * @var EavAttributeSetRepository
     */
    protected EavAttributeSetRepository $eavAttributeSetRepository;

    /**
     * @var EavEntityTypeRepository
     */
    protected EavEntityTypeRepository $eavEntityTypeRepository;

    /**
     * CreateDefaultCategory constructor.
     * @param CategoryRepository $categoryRepository
     * @param EavAttributeSetRepository $eavAttributeSetRepository
     * @param EavEntityTypeRepository $eavEntityTypeRepository
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        EavAttributeSetRepository $eavAttributeSetRepository,
        EavEntityTypeRepository $eavEntityTypeRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->eavAttributeSetRepository = $eavAttributeSetRepository;
        $this->eavEntityTypeRepository = $eavEntityTypeRepository;
    }

    /**
     * Setup Root Category
     */
    public function execute(): void
    {
        // Create Attribute Set
        $entityType = $this->eavEntityTypeRepository->getByTypeCode(CategoryEntity::class);
        $attributeSet = new EavAttributeSet();
        $attributeSet
            ->setAttributeSetName('Default Set')
            ->setEntityType($entityType);
        $this->eavAttributeSetRepository->save($attributeSet);

        // Create Root Category
        $rootCategory = new CategoryEntity();
        $rootCategory
            ->setCreatedAt()
            ->setUpdatedAt()
            ->setAttributeSet($attributeSet);
        $this->categoryRepository->save($rootCategory);

        // Create Default Category
        $this->createDefaultCategory($rootCategory, $attributeSet);
    }

    /**
     * @param CategoryEntity $parent
     * @param EavAttributeSet $attributeSet
     */
    private function createDefaultCategory(CategoryEntity $parent, EavAttributeSet $attributeSet)
    {
        $category = new CategoryEntity();
        $category
            ->setParent($parent)
            ->setCreatedAt()
            ->setUpdatedAt()
            ->setAttributeSet($attributeSet);

        // Save Default Category
        $this->categoryRepository->save($category);
    }

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [
            SetupEavModel::class
        ];
    }
}