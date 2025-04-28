<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Migrations\Category;

use Exception;
use ProgramCms\DataPatchBundle\Model\DataPatchInterface;
use ProgramCms\EavBundle\Entity\EavEntityType;
use ProgramCms\EavBundle\Model\Entity\Attribute\Backend\Image;
use ProgramCms\EavBundle\Repository\EavEntityTypeRepository;
use ProgramCms\EavBundle\Setup\EavSetup;
use ProgramCms\UserBundle\Entity\UserEavAttribute;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Entity\UserEntityInt;
use ProgramCms\UserBundle\Entity\UserEntityText;
use ProgramCms\UserBundle\Entity\UserEntityVarchar;

/**
 * Class EditCategoryEav
 * @package ProgramCms\CatalogBundle\Migrations\Category
 */
class EditCategoryEav implements DataPatchInterface
{
    /**
     * @var EavSetup
     */
    protected EavSetup $eavSetup;

    /**
     * UserEav constructor.
     * @param EavSetup $eavSetup
     */
    public function __construct(
        EavSetup $eavSetup
    )
    {
        $this->eavSetup = $eavSetup;
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $this->createAttributes();
    }

    /**
     * @throws Exception
     */
    private function createAttributes()
    {
        $this->eavSetup->addAttribute(
            UserEntity::class,
            'can_edit_categories',
            [
                'backend_type' => UserEntityVarchar::class,
                'frontend_input' => 'multiselect',
                'frontend_label' => 'Can Edit Categories',
                'is_required' => true,
                'note' => "User's Can Edit Categories Permission"
            ]
        );
    }

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }
}