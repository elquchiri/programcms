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
use ProgramCms\WebsiteBundle\Entity\WebsiteRoot;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Model\Collection\RootWebsite\Collection;

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
        /** @var WebsiteRoot $rootWebsite */
        foreach(parent::getData() as $rootWebsite) {
            $root = [
                'label' => $rootWebsite->getWebsiteRootName(),
                'is_active' => (int) $this->request->getParam('id') === $rootWebsite->getWebsiteRootId(),
                'count' => $rootWebsite->getWebsites()->count()
            ];

            if(!$rootWebsite->getWebsites()->isEmpty()) {
                $websites = $rootWebsite->getWebsites()->toArray();
                /** @var Website $website */
                foreach($websites as $website) {
                    $root['children'][$website->getWebsiteCode()] = [
                        'label' => $website->getWebsiteName(),
                        'is_active' => false,
                        'count' => $website->getWebsiteViews()->count()
                    ];

                    if(!$website->getWebsiteViews()->isEmpty()) {
                        /** @var WebsiteView $websiteView */
                        foreach($website->getWebsiteViews()->toArray() as $websiteView) {
                            $root['children'][$website->getWebsiteCode()]['children'][$websiteView->getWebsiteViewCode()] = [
                                'label' => $websiteView->getWebsiteViewName(),
                                'is_active' => false
                            ];
                        }
                    }
                }
            }
            $tree[$rootWebsite->getWebsiteRootCode()] = $root;
        }

        return $tree;
    }
}