<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Model\Provider\Source;

use ProgramCms\UiBundle\Model\Provider\DataSource\Options;
use ProgramCms\UserBundle\Entity\Group\UserGroup;
use ProgramCms\UserBundle\Model\ResourceModel\Group\Collection;

/**
 * Class UserGroups
 * @package ProgramCms\UserBundle\Model\Provider\Source
 */
class UserGroups extends Options
{
    /**
     * @var Collection
     */
    protected Collection $collection;

    /**
     * UserGroups constructor.
     * @param Collection $collection
     */
    public function __construct(
        Collection $collection
    )
    {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        $groups = [];
        /** @var UserGroup $group */
        foreach($this->collection->getData() as $group) {
            $groups[$group->getCode()] = $group->getName();
        }
        return $groups;
    }
}