<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Migrations\Category;

use ProgramCms\CatalogBundle\Entity\Category;
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
        $entityType = $this->eavEntityTypeRepository->getByTypeCode(Category::class);
        $attributeSet = new EavAttributeSet();
        $attributeSet
            ->setAttributeSetName('Default Set')
            ->setEntityType($entityType);
        $this->eavAttributeSetRepository->save($attributeSet);

        // Create Root Category
        $category = new Category();
        $category
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