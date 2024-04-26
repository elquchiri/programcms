<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Migrations\Category;

use Exception;
use ProgramCms\CatalogBundle\Entity\Category;
use ProgramCms\CatalogBundle\Entity\CategoryEavAttribute;
use ProgramCms\CatalogBundle\Entity\CategoryEntityVarchar;
use ProgramCms\DataPatchBundle\Model\AbstractDataPatch;
use ProgramCms\EavBundle\Entity\EavAttributeSet;
use ProgramCms\EavBundle\Entity\EavEntityType;
use ProgramCms\EavBundle\Repository\EavAttributeSetRepository;
use ProgramCms\EavBundle\Repository\EavEntityTypeRepository;
use ProgramCms\EavBundle\Setup\EavSetup;

/**
 * Class SetupEavModel
 * @package ProgramCms\CatalogBundle\Migrations\Category
 */
class SetupEavModel extends AbstractDataPatch
{
    /**
     * @var EavEntityTypeRepository
     */
    protected EavEntityTypeRepository $entityTypeRepository;

    /**
     * @var EavSetup
     */
    protected EavSetup $eavSetup;

    /**
     * @var EavAttributeSetRepository
     */
    protected EavAttributeSetRepository $eavAttributeSetRepository;

    /**
     * SetupEavModel constructor.
     * @param EavEntityTypeRepository $entityTypeRepository
     * @param EavAttributeSetRepository $eavAttributeSetRepository
     * @param EavSetup $eavSetup
     */
    public function __construct(
        EavEntityTypeRepository $entityTypeRepository,
        EavAttributeSetRepository $eavAttributeSetRepository,
        EavSetup $eavSetup
    )
    {
        $this->entityTypeRepository = $entityTypeRepository;
        $this->eavSetup = $eavSetup;
        $this->eavAttributeSetRepository = $eavAttributeSetRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $this->createEntityType();
        $this->createAttributeSet();
        $this->createAttributes();
    }

    /**
     * Setup Category Entity Type
     */
    private function createEntityType()
    {
        $entityType = new EavEntityType();
        $entityType
            ->setEntityTypeCode(Category::class)
            ->setAdditionalAttributeTable(CategoryEavAttribute::class);
        $this->entityTypeRepository->save($entityType);
    }

    /**
     * Setup Attributes
     * @throws Exception
     */
    private function createAttributes()
    {
        $this->eavSetup->addAttribute(
            Category::class,
            'name',
            [
                'backend_type' => CategoryEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Category Name',
                'is_required' => true,
                'note' => "Category name"
            ]
        );
    }

    /**
     * Setup Attribute Set
     */
    private function createAttributeSet()
    {
        $entityType = $this->entityTypeRepository->getByTypeCode(Category::class);
        $attributeSet = new EavAttributeSet();
        $attributeSet
            ->setAttributeSetName('Default Set')
            ->setEntityType($entityType);
        // Save Attribute Set
        $this->eavAttributeSetRepository->save($attributeSet);
    }
}