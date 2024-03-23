<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Repository;

use ProgramCms\CoreBundle\Model\Db\Entity\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class AbstractRepository
 * @package ProgramCms\CoreBundle\Repository
 */
abstract class AbstractRepository extends ServiceEntityRepository implements RepositoryInterface
{
    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->find($id);
    }
    /**
     * Save Entity
     * @param EntityInterface $entity
     * @param bool $flush
     */
    public function save(EntityInterface $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Remove Entity
     * @param EntityInterface $entity
     * @param bool $flush
     */
    public function remove(EntityInterface $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->findAll();
    }
}