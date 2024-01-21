<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Exception;
use ProgramCms\EavBundle\Entity\Entity;
use ProgramCms\EavBundle\Model\Config;

use function get_class;

/**
 * Class EavEntityListener
 * @package ProgramCms\EavBundle\EventListener
 */
class EavEntityListener
{
    /**
     * @var Config
     */
    protected Config $config;
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * EntityListener constructor.
     * @param EntityManagerInterface $entityManager
     * @param Config $config
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        Config $config
    )
    {
        $this->config = $config;
        $this->entityManager = $entityManager;
    }

    /**
     * @param PostLoadEventArgs $args
     * @throws Exception
     */
    public function postLoad(PostLoadEventArgs $args): void
    {
        $entity = $args->getObject();
        if($entity instanceof Entity) {
            $entityAttributes = $this->getEntityAttributes($entity);
        }
    }

    /**
     * @param Entity $entity
     * @return array
     * @throws Exception
     */
    private function getEntityAttributes(Entity $entity): array
    {
        $metadata = $this->entityManager->getClassMetadata(get_class($entity));
        $eavEntityType = $metadata->getTableName();
        return $eavEntityType === null  ? [] : $this->config->getEntityAttributes($eavEntityType, $entity);
    }
}