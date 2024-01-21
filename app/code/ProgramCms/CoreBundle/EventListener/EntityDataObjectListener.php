<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostLoadEventArgs;
use ProgramCms\CoreBundle\Model\DataObject;

use function get_class;

/**
 * Class EntityDataObjectListener
 * @package ProgramCms\CoreBundle\EventListener
 */
class EntityDataObjectListener
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * EntityListener constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
    )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param PostLoadEventArgs $args
     */
    public function postLoad(PostLoadEventArgs $args): void
    {
        $entity = $args->getObject();
        if($entity instanceof DataObject) {
            // Get metadata for the entity
            $metadata = $this->entityManager->getClassMetadata(get_class($entity));

            // Get all mapped fields
            $mappedFields = $metadata->getFieldNames();

            // Init Entity Data Object with mapped fields
            foreach($mappedFields as $field)
            {
                $entity->setData(
                    $field,
                    $entity->getDataUsingMethod($field)
                );
            }
        }
    }
}