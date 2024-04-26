<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Mapping\ClassMetadata;
use ProgramCms\CoreBundle\Helper\AbstractHelper;
use ProgramCms\CoreBundle\Helper\Context;

/**
 * Class Entity
 * @package ProgramCms\EavBundle\Helper
 */
class Entity extends AbstractHelper
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * Entity constructor.
     * @param Context $context
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        Context $context,
        EntityManagerInterface $entityManager
    )
    {
        parent::__construct($context);
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $tableName
     * @return string|null
     */
    public function getEntityClassNameFromTableName(string $tableName): ?string
    {
        /** @var ClassMetadata[] $allMetadata */
        $allMetadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        foreach ($allMetadata as $metadata) {
            if ($metadata->getTableName() === $tableName) {
                return $metadata->getName();
            }
        }

        return null;
    }
}