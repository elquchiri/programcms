<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Model\Provider\DataSource\Acl;

use ProgramCms\AclBundle\Entity\Role;
use ProgramCms\AclBundle\Repository\RoleRepository;
use ProgramCms\UiBundle\Model\Provider\DataSource\Options;

/**
 * Class Roles
 * @package ProgramCms\AclBundle\Model\Provider\DataSource\Acl
 */
class Roles extends Options
{
    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;

    /**
     * Roles constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        RoleRepository $roleRepository
    )
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return array
     */
    public function getOptionsArray(): array
    {
        $roles = [];
        /** @var Role $role */
        foreach($this->roleRepository->findAll() as $role) {
            $roles[$role->getRoleCode()] = $role->getRoleName();
        }
        return $roles;
    }
}