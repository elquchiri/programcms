<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\DriveBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\DriveBundle\Entity\DriveFile;

/**
 * Class DriveFileRepository
 * @package ProgramCms\DriveBundle\Repository
 */
class DriveFileRepository extends AbstractRepository
{
    /**
     * DriveFileRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, DriveFile::class);
    }

    /**
     * @param string $qWord
     * @return mixed
     */
    public function findByKeyword(string $qWord): mixed
    {
        $qb = $this->createQueryBuilder('d');
        $fields = ['d.name', 'd.description', 'd.size'];
        $orX = $qb->expr()->orX();
        foreach ($fields as $field) {
            $orX->add($qb->expr()->like($field, ':keyword'));
        }
        $qb->where($orX)
            ->setParameter('keyword', '%' . $qWord . '%');
        return $qb->getQuery()->getResult();
    }
}