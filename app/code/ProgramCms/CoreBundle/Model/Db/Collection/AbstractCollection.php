<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\Model\Db\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

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
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
        $this->_construct();
    }

    protected function _construct()
    {
        // Please override this one instead of overriding real __construct constructor
    }

    /**
     * @param string $entityClass
     */
    protected function _initEntity(string $entityClass)
    {
        $this->entity = $entityClass;
    }

    /**
     * Used internally to populate collection
     * @return void
     */
    protected function doInitialize()
    {
        $query = $this->entityManager->createQuery(
            "SELECT mainEntity FROM {$this->entity} mainEntity"
        );

        /**
         * Init Data Collection
         * Can be processed by end users to sort, add, delete or get items
         */
        $this->collection = new ArrayCollection($query->getResult());
    }
}