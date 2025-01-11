<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Migrations;

use ProgramCms\DataPatchBundle\Model\AbstractDataPatch;
use ProgramCms\EavBundle\Setup\EavSetup;
use ProgramCms\PageBundle\Entity\PageEntity;
use ProgramCms\PageBundle\Entity\PageEavAttribute;
use ProgramCms\PageBundle\Entity\PageEntityText;
use ProgramCms\PageBundle\Entity\PageEntityVarchar;

/**
 * Class SetupEavModel
 * @package ProgramCms\PageBundle\Migrations
 */
class SetupEavModel extends AbstractDataPatch
{
    /**
     * @var EavSetup
     */
    protected EavSetup $eavSetup;

    /**
     * SetupEavModel constructor.
     * @param EavSetup $eavSetup
     */
    public function __construct(
        EavSetup $eavSetup
    )
    {
        $this->eavSetup = $eavSetup;
    }

    /**
     * Setup Page Eav Model
     */
    public function execute(): void
    {
        $this->createPageEntityType();
        $this->createDefaultAttributeSet();
        $this->createAttributes();
    }

    /**
     * Setup Page Eav Entity Type
     */
    private function createPageEntityType()
    {
        $this->eavSetup->addEntityType(
            PageEntity::class,
            ['additional_attribute_entity' => PageEavAttribute::class]
        );
    }

    /**
     * Setup Page Default Attribute Set
     */
    private function createDefaultAttributeSet()
    {
        $this->eavSetup->addAttributeSet(
            PageEntity::class,
            ['attribute_set_name' => 'Default Set']
        );
    }

    private function createAttributes()
    {
        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_enable',
            [
                'backend_type' => PageEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Page Enable',
                'is_required' => true,
                'note' => "Page Enable"
            ]
        );

        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_name',
            [
                'backend_type' => PageEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Page Name',
                'is_required' => true,
                'note' => "Page Name"
            ]
        );

        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_image',
            [
                'backend_type' => PageEntityVarchar::class,
                'backend_model' => \ProgramCms\EavBundle\Model\Entity\Attribute\Backend\Image::class,
                'frontend_model' => \ProgramCms\EavBundle\Model\Entity\Attribute\Frontend\Image::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Page Image',
                'is_required' => true,
                'note' => "Page Image"
            ]
        );

        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_short_description',
            [
                'backend_type' => PageEntityText::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Short Description',
                'is_required' => true,
                'note' => "Short Description"
            ]
        );

        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_content',
            [
                'backend_type' => PageEntityText::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Page Content',
                'is_required' => true,
                'note' => "Page Content"
            ]
        );

        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_sort_order',
            [
                'backend_type' => PageEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Sort Order',
                'is_required' => true,
                'note' => "Sort Order"
            ]
        );

        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_url_key',
            [
                'backend_type' => PageEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'URL Key',
                'is_required' => true,
                'note' => "URL Key"
            ]
        );

        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_meta_title',
            [
                'backend_type' => PageEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Meta Title',
                'is_required' => true,
                'note' => "Meta Title"
            ]
        );

        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_meta_keywords',
            [
                'backend_type' => PageEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Meta Keywords',
                'is_required' => true,
                'note' => "Meta Keywords"
            ]
        );

        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_meta_description',
            [
                'backend_type' => PageEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Meta Description',
                'is_required' => true,
                'note' => "Meta Description"
            ]
        );

        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_html',
            [
                'backend_type' => PageEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Page HTML',
                'is_required' => true,
                'note' => "Meta HTML Content"
            ]
        );

        $this->eavSetup->addAttribute(
            PageEntity::class,
            'page_css',
            [
                'backend_type' => PageEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Page CSS',
                'is_required' => true,
                'note' => "Page CSS Content"
            ]
        );
    }
}