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
use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Repository\PostRepository;
use ProgramCms\RewriteBundle\Entity\UrlRewrite;
use ProgramCms\RewriteBundle\Repository\UrlRewriteRepository;

/**
 * Class PostPersistSubscriber
 * @package ProgramCms\RewriteBundle\EventListener
 */
class PostPersistSubscriber implements EventSubscriber
{
    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * @var UrlRewriteRepository
     */
    protected UrlRewriteRepository $urlRewriteRepository;

    /**
     * @var array
     */
    private array $queuedRewrites;

    /**
     * PostPersistSubscriber constructor.
     * @param PostRepository $postRepository
     * @param UrlRewriteRepository $urlRewriteRepository
     */
    public function __construct(
        PostRepository $postRepository,
        UrlRewriteRepository $urlRewriteRepository
    )
    {
        $this->postRepository = $postRepository;
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
        /** @var PostEntity $entity */
        foreach($entitiesToSave as $entity) {
            if($entity instanceof PostEntity) {
                $urlKey = $entity->getPostUrlKey();
                if(!empty($urlKey)) {
                    $postCategories = $entity->getCategories();
                    /** @var CategoryEntity $category */
                    foreach($postCategories as $category) {
                        $fullUrlKey = $category->getCategoryUrlKey() . '/' . $urlKey;
                        $urlRewrite = $this->urlRewriteRepository->getByRequestPath($fullUrlKey);
                        if(!$urlRewrite) {
                            $newRewrite = new UrlRewrite();
                            $newRewrite
                                ->setRequestPath($fullUrlKey)
                                ->setTargetPath('post_index_view')
                                ->setArguments('{"category":'. $category->getEntityId() .',"id":'. $entity->getEntityId() .'}')
                                ->setRedirectType(0);
                            $this->queuedRewrites[] = $newRewrite;
                        }
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