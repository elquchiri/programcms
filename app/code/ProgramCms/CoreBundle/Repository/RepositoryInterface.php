<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Repository;

use ProgramCms\CoreBundle\Model\Db\Entity\EntityInterface;

/**
 * Interface RepositoryInterface
 * @package ProgramCms\CoreBundle\Repository
 */
interface RepositoryInterface
{
    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object;

    /**
     * @param EntityInterface $entity
     * @param bool $flush
     */
    public function save(EntityInterface $entity, bool $flush = true): void;

    /**
     * @param EntityInterface $entity
     * @param bool $flush
     */
    public function remove(EntityInterface $entity, bool $flush = false): void;

    /**
     * Find All
     * @return array
     */
    public function getList(): array;
}