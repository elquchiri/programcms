<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Resolver;

use Exception;
use ProgramCms\CoreBundle\App\ScopeInterface;
use ProgramCms\CoreBundle\App\ScopeResolverInterface;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;

/**
 * Class Website
 * @package ProgramCms\WebsiteBundle\Model\Resolver
 */
class Website implements ScopeResolverInterface
{
    /**
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * Website constructor.
     * @param WebsiteRepository $websiteRepository
     */
    public function __construct(
        WebsiteRepository $websiteRepository
    )
    {
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @param null $scopeId
     * @return ScopeInterface
     * @throws Exception
     */
    public function getScope($scopeId = null)
    {
        $scope = $this->websiteRepository->getById($scopeId);
        if(!$scope instanceof ScopeInterface) {
            throw new Exception('The scope object is invalid.');
        }

        return $scope;
    }

    /**
     * @return \ProgramCms\WebsiteBundle\Entity\Website[]
     */
    public function getScopes()
    {
        return $this->websiteRepository->findAll();
    }
}