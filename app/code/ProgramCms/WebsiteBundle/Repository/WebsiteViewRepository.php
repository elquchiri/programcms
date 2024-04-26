<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class WebsiteViewRepository
 * @package ProgramCms\WebsiteBundle\Repository
 */
class WebsiteViewRepository extends AbstractRepository
{
    /**
     * WebsiteViewRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WebsiteView::class);
    }

    /**
     * @param int $id
     * @return WebsiteView|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy(['website_view_id' => $id]);
    }

    /**
     * @param string $code
     * @return object|null
     */
    public function getByCode(string $code): ?object
    {
        return $this->findOneBy(['website_view_code' => $code]);
    }
}
