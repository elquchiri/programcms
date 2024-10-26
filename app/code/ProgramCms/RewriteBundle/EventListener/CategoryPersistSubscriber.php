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
use ProgramCms\CatalogBundle\Repository\CategoryRepository;
use ProgramCms\RewriteBundle\Entity\UrlRewrite;
use ProgramCms\RewriteBundle\Repository\UrlRewriteRepository;

/**
 * Class CategoryPersistSubscriber
 * @package ProgramCms\RewriteBundle\EventListener
 */
class CategoryPersistSubscriber implements EventSubscriber
{
    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * @var UrlRewriteRepository
     */
    protected UrlRewriteRepository $urlRewriteRepository;

    /**
     * @var array
     */
    private array $queuedRewrites;

    /**
     * CategoryPersistSubscriber constructor.
     * @param CategoryRepository $categoryRepository
     * @param UrlRewriteRepository $urlRewriteRepository
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        UrlRewriteRepository $urlRewriteRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
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
        /** @var CategoryEntity $entity */
        foreach($entitiesToSave as $entity) {
            if($entity instanceof CategoryEntity) {
                $urlKey = $entity->getCategoryUrlKey();
                if(!empty($urlKey)) {
                    $urlRewrite = $this->urlRewriteRepository->getByRequestPath($urlKey);
                    if(!$urlRewrite) {
                        $newRewrite = new UrlRewrite();
                        $newRewrite
                            ->setRequestPath($urlKey)
                            ->setTargetPath('catalog_category_view')
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