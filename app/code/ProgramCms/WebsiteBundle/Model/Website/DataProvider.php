<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Website;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\WebsiteBundle\Entity\Website;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Model\Collection\Website\Collection;

/**
 * Class DataProvider
 * @package ProgramCms\WebsiteBundle\Model\Website
 */
class DataProvider extends \ProgramCms\UiBundle\DataProvider\AbstractDataProvider
{
    protected Request $request;

    /**
     * DataProvider constructor.
     * @param Collection $collection
     */
    public function __construct(
        Collection $collection,
        Request $request
    )
    {
        $this->collection = $collection;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        // Tree structure holding all websites data
        $tree = [];
        /** @var Website $website */
        foreach(parent::getData() as $website) {
            $root = [
                'label' => $website->getWebsiteName(),
                'is_active' => (int) $this->request->getParam('id') === $website->getWebsiteId(),
                'count' => $website->getGroups()->count()
            ];

            if(!$website->getGroups()->isEmpty()) {
                $groups = $website->getGroups()->toArray();
                /** @var Website $website */
                foreach($groups as $group) {
                    $root['children'][$group->getWebsiteGroupCode()] = [
                        'label' => $group->getWebsiteGroupName(),
                        'is_active' => false,
                        'count' => $group->getWebsiteViews()->count()
                    ];

                    if(!$group->getWebsiteViews()->isEmpty()) {
                        /** @var WebsiteView $websiteView */
                        foreach($group->getWebsiteViews()->toArray() as $websiteView) {
                            $root['children'][$group->getWebsiteGroupCode()]['children'][$websiteView->getWebsiteViewCode()] = [
                                'label' => $websiteView->getWebsiteViewName(),
                                'is_active' => false
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