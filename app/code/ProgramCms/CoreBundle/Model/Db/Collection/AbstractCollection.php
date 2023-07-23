<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Db\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

/**
 * Class AbstractCollection
 * @package ProgramCms\CoreBundle\Model\Db\Collection
 */
abstract class AbstractCollection extends \Doctrine\Common\Collections\AbstractLazyCollection
{
    /**
     * @var string
     */
    protected string $entity;
    /**
     * @var Connection
     */
    protected Connection $connection;

    public function __construct(
        Connection $connection
    )
    {
        $this->connection = $connection;
        $this->_construct();
    }

    protected function _construct()
    {
        // Please override this one instead of overriding real __construct constructor
    }

    /**
     * @param string $entity
     */
    protected function _initEntity(string $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @throws Exception
     */
    protected function doInitialize()
    {
        $this->collection = new ArrayCollection(
            $this->connection->createQueryBuilder()
                ->select('*')
                ->from($this->entity)
                ->fetchAllAssociative()
        );
    }
}