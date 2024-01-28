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
use ProgramCms\EavBundle\Entity\EavEntityType;
use ProgramCms\EavBundle\Model\Entity\Entity;

/**
 * Class EavEntityListener
 * @package ProgramCms\EavBundle\EventListener
 */
class EavEntityListener
{

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * EavEntityListener constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
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
            /** @var EavEntityType $eavEntityType */
            $eavEntityType = $this->entityManager
                ->getRepository(EavEntityType::class)
                ->findOneBy(['entity_type_code' => get_class($entity)]);

            if ($eavEntityType) {
                $entity->setEntityType($eavEntityType);
            }
        }
    }
}