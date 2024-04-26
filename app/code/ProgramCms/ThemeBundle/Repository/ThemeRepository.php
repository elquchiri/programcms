<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\ThemeBundle\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ThemeRepository
 * @package ProgramCms\ThemeBundle\Repository
 */
class ThemeRepository extends AbstractRepository
{
    /**
     * ThemeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Theme::class);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy(['theme_id' => $id]);
    }

    /**
     * @param string $themePath
     * @return object|null
     */
    public function getByThemePath(string $themePath): ?object
    {
        return $this->findOneBy(['theme_path' => $themePath]);
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
