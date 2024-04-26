<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Migrations;

use Exception;
use ProgramCms\DataPatchBundle\Model\DataPatchInterface;
use ProgramCms\EavBundle\Entity\EavEntityType;
use ProgramCms\EavBundle\Model\Entity\Attribute\Backend\Image;
use ProgramCms\EavBundle\Repository\EavEntityTypeRepository;
use ProgramCms\EavBundle\Setup\EavSetup;
use ProgramCms\UserBundle\Entity\UserEavAttribute;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Entity\UserEntityText;
use ProgramCms\UserBundle\Entity\UserEntityVarchar;

/**
 * Class UserEav
 * @package ProgramCms\UserBundle\Migrations
 */
class UserEav implements DataPatchInterface
{
    /**
     * @var EavSetup
     */
    protected EavSetup $eavSetup;

    /**
     * @var EavEntityTypeRepository
     */
    protected EavEntityTypeRepository $eavEntityTypeRepository;

    /**
     * UserEav constructor.
     * @param EavSetup $eavSetup
     * @param EavEntityTypeRepository $eavEntityTypeRepository
     */
    public function __construct(
        EavSetup $eavSetup,
        EavEntityTypeRepository $eavEntityTypeRepository
    )
    {
        $this->eavSetup = $eavSetup;
        $this->eavEntityTypeRepository = $eavEntityTypeRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $this->createEntityType();
        $this->createAttributes();
    }

    /**
     * Create Entity Type
     */
    public function createEntityType()
    {
        $entityType = new EavEntityType();
        $entityType
            ->setEntityTypeCode(UserEntity::class)
            ->setAdditionalAttributeTable(UserEavAttribute::class);
        $this->eavEntityTypeRepository->save($entityType);
    }

    /**
     * @throws Exception
     */
    private function createAttributes()
    {
        $this->eavSetup->addAttribute(
            UserEntity::class,
            'birthday',
            [
                'backend_type' => UserEntityVarchar::class,
                'frontend_input' => 'date',
                'frontend_label' => 'Birthday',
                'is_required' => true,
                'note' => "User's birthday data"
            ]
        );

        $this->eavSetup->addAttribute(
            UserEntity::class,
            'profile_image',
            [
                'backend_type' => UserEntityVarchar::class,
                'backend_model' => Image::class,
                'frontend_model' => \ProgramCms\EavBundle\Model\Entity\Attribute\Frontend\Image::class,
                'frontend_input' => 'imageUploader',
                'frontend_label' => 'Profile Image',
                'is_required' => true,
                'note' => "User's profile image"
            ]
        );

        $this->eavSetup->addAttribute(
            UserEntity::class,
            'biography',
            [
                'backend_type' => UserEntityText::class,
                'frontend_input' => 'textarea',
                'frontend_label' => 'Biography',
                'is_required' => true,
                'note' => "User's biography"
            ]
        );

        $this->eavSetup->addAttribute(
            UserEntity::class,
            'sex',
            [
                'backend_type' => UserEntityText::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Sex',
                'is_required' => true,
                'note' => "User's sex"
            ]
        );

        $this->eavSetup->addAttribute(
            UserEntity::class,
            'name_prefix',
            [
                'backend_type' => UserEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Name Prefix',
                'is_required' => true,
                'note' => "User's name prefix"
            ]
        );

        $this->eavSetup->addAttribute(
            UserEntity::class,
            'name_suffix',
            [
                'backend_type' => UserEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Name Suffix',
                'is_required' => true,
                'note' => "User's name suffix"
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