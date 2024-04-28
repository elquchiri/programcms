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
use ProgramCms\PostBundle\Entity\Post;
use ProgramCms\PostBundle\Entity\PostEavAttribute;

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
    }

    /**
     * Setup Post Eav Entity Type
     */
    private function createPostEntityType()
    {
        $this->eavSetup->addEntityType(
            Post::class,
            ['additional_attribute_entity' => PostEavAttribute::class]
        );
    }

    /**
     * Setup Post Default Attribute Set
     */
    private function createDefaultAttributeSet()
    {
        $this->eavSetup->addAttributeSet(
            Post::class,
            ['attribute_set_name' => 'Default Set']
        );
    }
}