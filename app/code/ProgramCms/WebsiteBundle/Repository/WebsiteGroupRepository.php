<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Repository;

use Doctrine\Common\Collections\AbstractLazyCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\LazyCriteriaCollection;
use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\WebsiteBundle\Entity\WebsiteGroup;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class WebsiteGroupRepository
 * @package ProgramCms\WebsiteBundle\Repository
 */
class WebsiteGroupRepository extends AbstractRepository
{
    /**
     * WebsiteGroupRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsiteGroup::class);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy(['website_group_id' => $id]);
    }

    /**
     * @param string $code
     * @return object|null
     */
    public function getByCode(string $code): ?object
    {
        return $this->findOneBy(['website_group_code' => $code]);
    }

    /**
     * @return AbstractLazyCollection|LazyCriteriaCollection
     */
    public function findAll()
    {
        $criteria = Criteria::create();
        return $this->matching($criteria->andWhere(Criteria::expr()->neq('website_group_code', 'admin')));
    }
}
