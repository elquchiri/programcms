<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Resolver;

use ProgramCms\CoreBundle\App\ScopeInterface;
use ProgramCms\CoreBundle\App\ScopeResolverInterface;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;

/**
 * Class WebsiteGroup
 * @package ProgramCms\WebsiteBundle\Model\Resolver
 */
class WebsiteGroup implements ScopeResolverInterface
{
    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;

    /**
     * WebsiteGroup constructor.
     * @param WebsiteGroupRepository $websiteGroupRepository
     */
    public function __construct(
        WebsiteGroupRepository $websiteGroupRepository
    )
    {
        $this->websiteGroupRepository = $websiteGroupRepository;
    }

    /**
     * @param null $scopeId
     * @return ScopeInterface
     */
    public function getScope($scopeId = null)
    {
        $scope = $this->websiteGroupRepository->getById($scopeId);
        if(!$scope instanceof ScopeInterface) {
            throw new Exception('The scope object is invalid.');
        }

        return $scope;
    }

    /**
     * @return \ProgramCms\WebsiteBundle\Entity\WebsiteGroup[]
     */
    public function getScopes()
    {
        return $this->websiteGroupRepository->findAll();
    }
}