<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Repository;

use ProgramCms\ThemeBundle\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Theme>
 *
 * @method Theme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Theme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Theme[]    findAll()
 * @method Theme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemeRepository extends ServiceEntityRepository
{
    /**
     * WebsiteRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Theme::class);
    }

    /**
     * @param int $themeId
     * @return Theme|null
     */
    public function getById(int $themeId): ?Theme
    {
        return $this->findOneBy(['theme_id' => $themeId]);
    }

    /**
     * @param Theme $entity
     * @param bool $flush
     */
    public function save(Theme $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Theme $entity
     * @param bool $flush
     */
    public function remove(Theme $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Get All Frontend Themes
     * @return Theme[]
     */
    public function getAllFrontendThemes(): array
    {
        return $this->findBy(['area' => 'frontend']);
    }

    /**
     * Get All Backend Themes
     * @return Theme[]
     */
    public function getAllBackendThemes(): array
    {
        return $this->findBy(['area' => 'adminhtml']);
    }
}
