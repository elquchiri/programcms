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
use ProgramCms\WebsiteBundle\Entity\Website;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;

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
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;

    /**
     * CreateDefaultCategory constructor.
     * @param CategoryRepository $categoryRepository
     * @param EavAttributeSetRepository $eavAttributeSetRepository
     * @param EavEntityTypeRepository $eavEntityTypeRepository
     * @param WebsiteRepository $websiteRepository
     * @param WebsiteGroupRepository $websiteGroupRepository
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        EavAttributeSetRepository $eavAttributeSetRepository,
        EavEntityTypeRepository $eavEntityTypeRepository,
        WebsiteRepository $websiteRepository,
        WebsiteGroupRepository $websiteGroupRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->eavAttributeSetRepository = $eavAttributeSetRepository;
        $this->eavEntityTypeRepository = $eavEntityTypeRepository;
        $this->websiteRepository = $websiteRepository;
        $this->websiteGroupRepository = $websiteGroupRepository;
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
        $defaultCategory = $this->createDefaultCategory($rootCategory, $attributeSet);

        // Assign default category to default website group
        $this->assignCategoryToWebsiteGroup($defaultCategory);
    }

    /**
     * @param CategoryEntity $parent
     * @param EavAttributeSet $attributeSet
     * @return CategoryEntity|null
     */
    private function createDefaultCategory(CategoryEntity $parent, EavAttributeSet $attributeSet): ?CategoryEntity
    {
        $category = new CategoryEntity();
        $category
            ->setParent($parent)
            ->setCreatedAt()
            ->setUpdatedAt()
            ->setAttributeSet($attributeSet);

        // Save Default Category
        $this->categoryRepository->save($category);

        return $category;
    }

    /**
     * @param CategoryEntity $defaultCategory
     */
    private function assignCategoryToWebsiteGroup(CategoryEntity $defaultCategory)
    {
        /** @var Website $website */
        $website = $this->websiteRepository->getDefaultWebsite();
        $group = $website->getDefaultGroup();
        $group->setCategory($defaultCategory);
        $this->websiteGroupRepository->save($group);
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