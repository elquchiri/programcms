<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\NewsletterBundle\Repository;

use ProgramCms\CoreBundle\Repository\AbstractRepository;
use ProgramCms\NewsletterBundle\Entity\Newsletter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class NewsletterRepository
 * @package ProgramCms\NewsletterBundle\Repository
 */
class NewsletterRepository extends AbstractRepository
{
    /**
     * NewsletterRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Newsletter::class);
    }
}
