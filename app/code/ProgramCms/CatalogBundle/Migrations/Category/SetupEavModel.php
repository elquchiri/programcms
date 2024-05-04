<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Migrations\Category;

use Exception;
use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CatalogBundle\Entity\CategoryEavAttribute;
use ProgramCms\CatalogBundle\Entity\CategoryEntityInt;
use ProgramCms\CatalogBundle\Entity\CategoryEntityText;
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
            ->setEntityTypeCode(CategoryEntity::class)
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
            CategoryEntity::class,
            'category_name',
            [
                'backend_type' => CategoryEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Category Name',
                'is_required' => true,
                'note' => "Category Name"
            ]
        );

        $this->eavSetup->addAttribute(
            CategoryEntity::class,
            'category_enable',
            [
                'backend_type' => CategoryEntityVarchar::class,
                'frontend_input' => 'switcher',
                'frontend_label' => 'Enable Category',
                'is_required' => true,
                'note' => "Category Status"
            ]
        );

        $this->eavSetup->addAttribute(
            CategoryEntity::class,
            'include_in_menu',
            [
                'backend_type' => CategoryEntityVarchar::class,
                'frontend_input' => 'switcher',
                'frontend_label' => 'Include in Menu',
                'is_required' => true,
                'note' => "Category include in menu"
            ]
        );
        $this->eavSetup->addAttribute(
            CategoryEntity::class,
            'category_image',
            [
                'backend_model' => \ProgramCms\EavBundle\Model\Entity\Attribute\Backend\Image::class,
                'frontend_model' => \ProgramCms\EavBundle\Model\Entity\Attribute\Frontend\Image::class,
                'backend_type' => CategoryEntityVarchar::class,
                'frontend_input' => 'imageUploader',
                'frontend_label' => 'Category Image',
                'is_required' => true,
                'note' => "Category Image"
            ]
        );

        $this->eavSetup->addAttribute(
            CategoryEntity::class,
            'category_description',
            [
                'backend_type' => CategoryEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Category Description',
                'is_required' => true,
                'note' => "Category Description"
            ]
        );

        $this->eavSetup->addAttribute(
            CategoryEntity::class,
            'category_display_mode',
            [
                'backend_type' => CategoryEntityVarchar::class,
                'frontend_input' => 'select',
                'frontend_label' => 'Display Mode',
                'is_required' => true,
                'note' => "Display Mode"
            ]
        );

        $this->eavSetup->addAttribute(
            CategoryEntity::class,
            'category_sort_order',
            [
                'backend_type' => CategoryEntityInt::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Sort Order',
                'is_required' => true,
                'note' => "Sort Order"
            ]
        );

        $this->eavSetup->addAttribute(
            CategoryEntity::class,
            'category_url_key',
            [
                'backend_type' => CategoryEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'URL Key',
                'is_required' => true,
                'note' => "URL Key"
            ]
        );

        $this->eavSetup->addAttribute(
            CategoryEntity::class,
            'category_meta_title',
            [
                'backend_type' => CategoryEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Meta Title',
                'is_required' => true,
                'note' => "Meta Title"
            ]
        );

        $this->eavSetup->addAttribute(
            CategoryEntity::class,
            'category_meta_keywords',
            [
                'backend_type' => CategoryEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Meta Keywords',
                'is_required' => true,
                'note' => "Meta Keywords"
            ]
        );

        $this->eavSetup->addAttribute(
            CategoryEntity::class,
            'category_meta_description',
            [
                'backend_type' => CategoryEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Meta Description',
                'is_required' => true,
                'note' => "Meta Description"
            ]
        );
    }

    /**
     * Setup Attribute Set
     */
    private function createAttributeSet()
    {
        $entityType = $this->entityTypeRepository->getByTypeCode(CategoryEntity::class);
        $attributeSet = new EavAttributeSet();
        $attributeSet
            ->setAttributeSetName('Default Set')
            ->setEntityType($entityType);
        // Save Attribute Set
        $this->eavAttributeSetRepository->save($attributeSet);
    }
}