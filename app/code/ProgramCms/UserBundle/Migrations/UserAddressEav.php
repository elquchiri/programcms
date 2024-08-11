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
use ProgramCms\EavBundle\Repository\EavEntityTypeRepository;
use ProgramCms\EavBundle\Setup\EavSetup;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntityInt;
use ProgramCms\UserBundle\Entity\UserEavAttribute;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntity;
use ProgramCms\UserBundle\Entity\Address\UserAddressEntityVarchar;

/**
 * Class UserAddressEav
 * @package ProgramCms\UserBundle\Migrations
 */
class UserAddressEav implements DataPatchInterface
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
     * UserAddressEav constructor.
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
            ->setEntityTypeCode(UserAddressEntity::class)
            ->setAdditionalAttributeTable(UserEavAttribute::class);
        $this->eavEntityTypeRepository->save($entityType);
    }

    /**
     * @throws Exception
     */
    private function createAttributes()
    {
        $this->eavSetup->addAttribute(
            UserAddressEntity::class,
            'city',
            [
                'backend_type' => UserAddressEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'City',
                'is_required' => true,
                'note' => "User's Address City"
            ]
        );

        $this->eavSetup->addAttribute(
            UserAddressEntity::class,
            'fax',
            [
                'backend_type' => UserAddressEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Fax',
                'is_required' => true,
                'note' => "User's Address Fax"
            ]
        );

        $this->eavSetup->addAttribute(
            UserAddressEntity::class,
            'firstname',
            [
                'backend_type' => UserAddressEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'First Name',
                'is_required' => true,
                'note' => "User's First Name"
            ]
        );

        $this->eavSetup->addAttribute(
            UserAddressEntity::class,
            'lastname',
            [
                'backend_type' => UserAddressEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Last Name',
                'is_required' => true,
                'note' => "User's Last Name"
            ]
        );

        $this->eavSetup->addAttribute(
            UserAddressEntity::class,
            'postcode',
            [
                'backend_type' => UserAddressEntityInt::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Post Code',
                'is_required' => true,
                'note' => "User's Address Post Code"
            ]
        );

        $this->eavSetup->addAttribute(
            UserAddressEntity::class,
            'region',
            [
                'backend_type' => UserAddressEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Region',
                'is_required' => true,
                'note' => "User's Address Region"
            ]
        );

        $this->eavSetup->addAttribute(
            UserAddressEntity::class,
            'street',
            [
                'backend_type' => UserAddressEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Street',
                'is_required' => true,
                'note' => "User's Address Street"
            ]
        );

        $this->eavSetup->addAttribute(
            UserAddressEntity::class,
            'telephone',
            [
                'backend_type' => UserAddressEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Telephone',
                'is_required' => true,
                'note' => "User's Telephone"
            ]
        );

        $this->eavSetup->addAttribute(
            UserAddressEntity::class,
            'country_code',
            [
                'backend_type' => UserAddressEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Country Code',
                'is_required' => true,
                'note' => "User's Address Country Code"
            ]
        );

        $this->eavSetup->addAttribute(
            UserAddressEntity::class,
            'zipcode',
            [
                'backend_type' => UserAddressEntityVarchar::class,
                'frontend_input' => 'text',
                'frontend_label' => 'Zip Code',
                'is_required' => true,
                'note' => "User's Address Zip Code"
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