<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\RewriteBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\UnitOfWork;
use ProgramCms\RewriteBundle\Entity\UrlRewrite;
use ProgramCms\RewriteBundle\Repository\UrlRewriteRepository;
use ProgramCms\UserBundle\Entity\UserEntity;
use ProgramCms\UserBundle\Repository\UserEntityRepository;

/**
 * Class UserPersistSubscriber
 * @package ProgramCms\RewriteBundle\EventListener
 */
class UserPersistSubscriber implements EventSubscriber
{
    /**
     * @var UserEntityRepository
     */
    protected UserEntityRepository $userRepository;

    /**
     * @var UrlRewriteRepository
     */
    protected UrlRewriteRepository $urlRewriteRepository;

    /**
     * @var array
     */
    private array $queuedRewrites;

    /**
     * UserPersistSubscriber constructor.
     * @param UserEntityRepository $userRepository
     * @param UrlRewriteRepository $urlRewriteRepository
     */
    public function __construct(
        UserEntityRepository $userRepository,
        UrlRewriteRepository $urlRewriteRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->urlRewriteRepository = $urlRewriteRepository;
    }

    /**
     * @param OnFlushEventArgs $args
     */
    public function onFlush(OnFlushEventArgs $args): void
    {
        /** @var UnitOfWork $unitOfWork */
        $entityManager = $args->getObjectManager();
        $unitOfWork = $entityManager->getUnitOfWork();
        // Get the entities scheduled for insertion, update, and deletion
        $entitiesToSave = array_merge($unitOfWork->getScheduledEntityUpdates(), $unitOfWork->getScheduledEntityInsertions());
        /** @var UserEntity $entity */
        foreach($entitiesToSave as $entity) {
            if($entity instanceof UserEntity) {
                $username = $entity->getUserName();
                if(!empty($username)) {
                    $urlRewrite = $this->urlRewriteRepository->getByRequestPath($username);
                    if(!$urlRewrite) {
                        $newRewrite = new UrlRewrite();
                        $newRewrite
                            ->setRequestPath($username)
                            ->setTargetPath('user_profile_view')
                            ->setArguments('{"id":'. $entity->getEntityId() .'}')
                            ->setRedirectType(0);
                        $this->queuedRewrites[] = $newRewrite;
                    }
                }
            }
        }
    }

    /**
     * @param PostFlushEventArgs $args
     */
    public function postFlush(PostFlushEventArgs $args): void
    {
        if (!empty($this->queuedRewrites)) {
            $entityManager = $args->getObjectManager();

            foreach ($this->queuedRewrites as $urlRewrite) {
                $entityManager->persist($urlRewrite);
            }
            $this->queuedRewrites = [];

            // Flush the new UrlRewrite entries
            $entityManager->flush();
        }
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
            Events::postFlush
        ];
    }
}