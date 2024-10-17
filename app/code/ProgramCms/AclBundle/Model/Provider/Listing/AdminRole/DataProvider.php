<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Model\Provider\Listing\AdminRole;

use ProgramCms\AclBundle\Entity\Role;
use ProgramCms\AclBundle\Repository\RoleRepository;
use ProgramCms\CoreBundle\App\RequestInterface;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use ProgramCms\AclBundle\Model\ResourceModel\Role\Collection;

/**
 * Class DataProvider
 * @package ProgramCms\AclBundle\Model\Provider\Listing\AdminRole
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;

    /**
     * DataProvider constructor.
     * @param Collection $collection
     * @param RequestInterface $request
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        Collection $collection,
        RequestInterface $request,
        RoleRepository $roleRepository
    )
    {
        $this->collection = $collection;
        $this->request = $request;
        $this->roleRepository = $roleRepository;
    }

    public function getData(): mixed
    {
        $roleId = $this->request->getParam('id');
        /** @var Role $role */
        $role = $this->roleRepository->getById($roleId);
        if($role) {
            return $role->getUsers()->toArray();
        }
        return [];
    }
}