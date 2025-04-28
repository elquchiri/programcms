<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostReactionBundle\EventSubscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\PostLoadEventArgs;
use ProgramCms\CoreBundle\Model\Db\Entity\AbstractEntity;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostReactionBundle\Repository\PostReactionRepository;

/**
 * Class DoctrineMappingSubscriber
 * @package ProgramCms\PostReactionBundle\EventSubscriber
 */
class DoctrineMappingSubscriber
{
    /**
     * @var PostReactionRepository
     */
    protected PostReactionRepository $postReactionRepository;

    /**
     * DoctrineMappingSubscriber constructor.
     * @param PostReactionRepository $postReactionRepository
     */
    public function __construct(PostReactionRepository $postReactionRepository)
    {
        $this->postReactionRepository = $postReactionRepository;
    }

    /**
     * @param PostLoadEventArgs $args
     */
    public function postLoad(PostLoadEventArgs $args): void
    {
        /** @var AbstractEntity $entity */
        $entity = $args->getObject();
        if($entity instanceof PostEntity) {
            $postReactions = $this->postReactionRepository->getByPost($entity);
            $entity->setData('reactions', new ArrayCollection($postReactions));
        }
    }
}