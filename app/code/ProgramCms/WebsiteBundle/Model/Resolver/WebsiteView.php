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
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class WebsiteView
 * @package ProgramCms\WebsiteBundle\Model\Resolver
 */
class WebsiteView implements ScopeResolverInterface
{
    /**
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;

    /**
     * WebsiteView constructor.
     * @param WebsiteViewRepository $websiteViewRepository
     */
    public function __construct(
        WebsiteViewRepository $websiteViewRepository
    )
    {
        $this->websiteViewRepository = $websiteViewRepository;
    }

    /**
     * @param null $scopeId
     * @return mixed|ScopeInterface|\ProgramCms\WebsiteBundle\Entity\WebsiteView
     * @throws Exception
     */
    public function getScope($scopeId = null)
    {
        $scope = $this->websiteViewRepository->getById($scopeId);
        if(!$scope instanceof ScopeInterface) {
            throw new Exception('The scope object is invalid.');
        }

        return $scope;
    }

    /**
     * @return \ProgramCms\WebsiteBundle\Entity\WebsiteView[]
     */
    public function getScopes()
    {
        return $this->websiteViewRepository->findAll();
    }
}