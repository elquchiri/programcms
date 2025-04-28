<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ManagerBundle\Model\Collection\Bundle;

use Doctrine\ORM\EntityManagerInterface;
use ProgramCms\CoreBundle\Entity\Bundle;
use ProgramCms\CoreBundle\Model\Utils\BundleManager;
use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package ProgramCms\ManagerBundle\Model\Collection\Bundle
 */
class Collection extends AbstractCollection
{

    /**
     * @var BundleManager
     */
    protected BundleManager $bundleManager;

    /**
     * Collection constructor.
     * @param EntityManagerInterface $entityManager
     * @param BundleManager $bundleManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        BundleManager $bundleManager,
    )
    {
        parent::__construct($entityManager);
        $this->bundleManager = $bundleManager;
    }

    protected function _construct()
    {
        $this->_initEntity(Bundle::class);
    }
}