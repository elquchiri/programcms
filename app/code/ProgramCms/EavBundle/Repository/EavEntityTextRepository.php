<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\EavBundle\Repository;

use ProgramCms\EavBundle\Entity\EavEntityText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EavEntityText>
 *
 * @method EavEntityText|null find($id, $lockMode = null, $lockVersion = null)
 * @method EavEntityText|null findOneBy(array $criteria, array $orderBy = null)
 * @method EavEntityText[]    findAll()
 * @method EavEntityText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EavEntityTextRepository extends ServiceEntityRepository
{

    /**
     * EavEntityTextRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EavEntityText::class);
    }

    /**
     * @param EavEntityText $entity
     * @param bool $flush
     */
    public function save(EavEntityText $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param EavEntityText $entity
     * @param bool $flush
     */
    public function remove(EavEntityText $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
