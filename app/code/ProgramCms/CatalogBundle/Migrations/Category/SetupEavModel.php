<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CatalogBundle\Migrations\Category;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\EavBundle\Entity\EavEntityType;

/**
 * Class SetupEavModel
 * @package ProgramCms\CatalogBundle\Migrations\Category
 */
class SetupEavModel extends \ProgramCms\DataPatchBundle\Model\AbstractDataPatchInterface
{
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    /**
     * @var \ProgramCms\EavBundle\Repository\EavEntityTypeRepository
     */
    protected \ProgramCms\EavBundle\Repository\EavEntityTypeRepository $eavEntityTypeRepository;

    public function __construct(
        ObjectManager $objectManager,
        \ProgramCms\EavBundle\Repository\EavEntityTypeRepository $eavEntityTypeRepository
    )
    {
        $this->objectManager = $objectManager;
        $this->eavEntityTypeRepository = $eavEntityTypeRepository;
    }

    public function execute(): void
    {
        /** @var EavEntityType $entity */
        $entity = $this->objectManager->create(EavEntityType::class);
        $entity->setEntityTypeCode('customer');

        $this->eavEntityTypeRepository->save($entity);
    }
}