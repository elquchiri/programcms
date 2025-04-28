<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Migrations;

use ProgramCms\DataPatchBundle\Model\AbstractDataPatch;
use ProgramCms\EavBundle\Setup\EavSetup;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Entity\PostEavAttribute;
use ProgramCms\PostBundle\Entity\PostEntityText;
use ProgramCms\PostBundle\Entity\PostEntityVarchar;

/**
 * Class SetupEavModel
 * @package ProgramCms\PostBundle\Migrations
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
     * Setup Post Eav Model
     */
    public function execute(): void
    {
        $this->createPostEntityType();
        $this->createDefaultAttributeSet();
        $this->createAttributes();
    }

    /**
     * Setup Post Eav Entity Type
     */
    private function createPostEntityType()
    {
        $this->eavSetup->addEntityType(
            PostEntity::class,
            ['additional_attribute_entity' => PostEavAttribute::class]
        );
    }

    /**
     * Setup Post Default Attribute Set
     */
    private function createDefaultAttributeSet()
    {
        $this->eavSetup->addAttributeSet(
            PostEntity::class,
            ['attribute_set_name' => 'Default Set']
        );
    }

    private function createAttributes()
    {
        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_enable',
            [
                'backend_type' => PostEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Post Enable',
                'is_required' => true,
                'note' => "Post Enable"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_name',
            [
                'backend_type' => PostEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Post Name',
                'is_required' => true,
                'note' => "Post Name"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_image',
            [
                'backend_type' => PostEntityVarchar::class,
                'backend_model' => \ProgramCms\EavBundle\Model\Entity\Attribute\Backend\Image::class,
                'frontend_model' => \ProgramCms\EavBundle\Model\Entity\Attribute\Frontend\Image::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Post Image',
                'is_required' => true,
                'note' => "Post Image"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_short_description',
            [
                'backend_type' => PostEntityText::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Short Description',
                'is_required' => true,
                'note' => "Short Description"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_content',
            [
                'backend_type' => PostEntityText::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Post Content',
                'is_required' => true,
                'note' => "Post Content"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_sort_order',
            [
                'backend_type' => PostEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Sort Order',
                'is_required' => true,
                'note' => "Sort Order"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_url_key',
            [
                'backend_type' => PostEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'URL Key',
                'is_required' => true,
                'note' => "URL Key"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_meta_title',
            [
                'backend_type' => PostEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Meta Title',
                'is_required' => true,
                'note' => "Meta Title"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_meta_keywords',
            [
                'backend_type' => PostEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Meta Keywords',
                'is_required' => true,
                'note' => "Meta Keywords"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_meta_description',
            [
                'backend_type' => PostEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Meta Description',
                'is_required' => true,
                'note' => "Meta Description"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_html',
            [
                'backend_type' => PostEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Post HTML',
                'is_required' => true,
                'note' => "Meta HTML Content"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_css',
            [
                'backend_type' => PostEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Post CSS',
                'is_required' => true,
                'note' => "Post CSS Content"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_pin',
            [
                'backend_type' => PostEntityVarchar::class,
                'frontend_input' => 'switcher',
                'frontend_label' => 'Post Pin',
                'is_required' => true,
                'note' => "Post Pin"
            ]
        );

        $this->eavSetup->addAttribute(
            PostEntity::class,
            'post_lock',
            [
                'backend_type' => PostEntityVarchar::class,
                'frontend_input' => 'switcher',
                'frontend_label' => 'Post Lock',
                'is_required' => false,
                'note' => "Post Lock"
            ]
        );
    }
}