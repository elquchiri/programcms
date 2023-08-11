<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Website;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\WebsiteBundle\Entity\Website;
use ProgramCms\WebsiteBundle\Entity\WebsiteGroup;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Model\Collection\Website\Collection;

/**
 * Class DataProvider
 * @package ProgramCms\WebsiteBundle\Model\Website
 */
class DataProvider extends \ProgramCms\UiBundle\DataProvider\AbstractDataProvider
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
     * DataProvider constructor.
     * @param Collection $collection
     * @param Request $request
     * @param Url $url
     */
    public function __construct(
        Collection $collection,
        Request $request,
        Url $url
    )
    {
        $this->collection = $collection;
        $this->request = $request;
        $this->url = $url;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        // Tree structure holding all websites data
        $tree = [];
        $routeName = $this->url->getRouteName();
        $id = $this->request->getParam('id');

        /** @var Website $website */
        foreach(parent::getData() as $website) {
            $root = [
                'label' => $website->getWebsiteName(),
                'is_active' => $routeName === 'website_website_edit' && (int)$id === $website->getWebsiteId(),
                'count' => $website->getGroups()->count(),
                'url' => $this->url->getUrlByRouteName('website_website_edit', ['id' => $website->getWebsiteId()])
            ];

            if(!$website->getGroups()->isEmpty()) {
                $groups = $website->getGroups()->toArray();
                /** @var WebsiteGroup $group */
                foreach($groups as $group) {
                    $root['children'][$group->getWebsiteGroupCode()] = [
                        'label' => $group->getWebsiteGroupName(),
                        'is_active' => $routeName === 'website_websitegroup_edit' && (int)$id === $group->getWebsiteGroupId(),
                        'count' => $group->getWebsiteViews()->count(),
                        'url' => $this->url->getUrlByRouteName('website_websitegroup_edit', ['id' => $group->getWebsiteGroupId()])
                    ];

                    if(!$group->getWebsiteViews()->isEmpty()) {
                        /** @var WebsiteView $websiteView */
                        foreach($group->getWebsiteViews()->toArray() as $websiteView) {
                            $root['children'][$group->getWebsiteGroupCode()]['children'][$websiteView->getWebsiteViewCode()] = [
                                'label' => $websiteView->getWebsiteViewName(),
                                'is_active' => $routeName === 'website_websiteview_edit' && (int)$id === $websiteView->getWebsiteViewId(),
                                'url' => $this->url->getUrlByRouteName('website_websiteview_edit', ['id' => $websiteView->getWebsiteViewId()])
                            ];
                        }
                    }
                }
            }
            $tree[$website->getWebsiteCode()] = $root;
        }

        return $tree;
    }
}