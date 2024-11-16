<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminChatBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use ProgramCms\AdminChatBundle\Entity\AdminMessage;
use ProgramCms\CoreBundle\Repository\AbstractRepository;

/**
 * Class AdminMessageRepository
 * @package ProgramCms\AdminChatBundle\Repository
 */
class AdminMessageRepository extends AbstractRepository
{
    /**
     * AdminMessageRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminMessage::class);
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): ?object
    {
        return $this->findOneBy([
            'message_id' => $id
        ]);
    }
}