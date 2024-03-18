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
use ProgramCms\WebsiteBundle\Model\WebsiteManager;

/**
 * Class WebsiteView
 * @package ProgramCms\WebsiteBundle\Model\Resolver
 */
class WebsiteView implements ScopeResolverInterface
{
    /**
     * @var WebsiteManager
     */
    protected WebsiteManager $websiteManager;

    /**
     * WebsiteView constructor.
     * @param WebsiteManager $websiteManager
     */
    public function __construct(
        WebsiteManager $websiteManager
    )
    {
        $this->websiteManager = $websiteManager;
    }

    /**
     * @param null $scopeId
     * @return mixed|ScopeInterface|\ProgramCms\WebsiteBundle\Entity\WebsiteView
     * @throws Exception
     */
    public function getScope($scopeId = null)
    {
        $scope = $this->websiteManager->getWebsiteView($scopeId);
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
        return $this->websiteManager->getWebsiteViews();
    }
}