<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AclBundle\Model\Provider\DataSource\Acl;

use ProgramCms\AclBundle\Entity\Permission;
use ProgramCms\AclBundle\Entity\Role;
use ProgramCms\AclBundle\Model\AclSerializer;
use ProgramCms\AclBundle\Repository\RoleRepository;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\RouterBundle\Service\UrlInterface as Url;
use ProgramCms\UiBundle\DataProvider\AbstractDataProvider;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class DataProvider
 * @package ProgramCms\AclBundle\Model\Provider\DataSource\Acl
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Url
     */
    protected Url $url;

    /**
     * @var AclSerializer
     */
    protected AclSerializer $aclSerializer;

    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;

    /**
     * DataProvider constructor.
     * @param AclSerializer $aclSerializer
     * @param Request $request
     * @param Url $url
     * @param Security $security
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        AclSerializer $aclSerializer,
        Request $request,
        Url $url,
        Security $security,
        RoleRepository $roleRepository
    )
    {
        $this->request = $request;
        $this->url = $url;
        $this->aclSerializer = $aclSerializer;
        $this->security = $security;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $tree = [];
        $acl = $this->aclSerializer->getAcl();
        foreach($acl as $aclKey => $aclValue) {
            $tree[] = $this->buildTree($aclKey, $aclValue);
        }

        return $tree;
    }

    /**
     * @param string $aclKey
     * @param array $acl
     * @return array
     */
    private function buildTree(string $aclKey, array $acl): array {
        $tree = [
            'label' => $acl['label'] ?? '',
            'is_active' => $this->isAclChecked($aclKey),
            'value' => $aclKey,
            'children' => []
        ];

        foreach($acl as $keyAcl => $aclEntry) {
            if(!is_array($aclEntry)) {
                continue;
            }
            // Process ACL children
            $tree['children'][$keyAcl] = $this->buildTree($keyAcl, $aclEntry);
        }

        return $tree;
    }

    /**
     * @param string $aclKey
     * @return bool
     */
    private function isAclChecked(string $aclKey): bool
    {
        if($this->request->hasParam('id')) {
            $roleId = $this->request->getParam('id');
            /** @var Role $role */
            $role = $this->roleRepository->getById($roleId);
            if($role) {
                /** @var Permission $permission */
                foreach($role->getPermissions() as $permission) {
                    if($aclKey == $permission->getResource()) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}