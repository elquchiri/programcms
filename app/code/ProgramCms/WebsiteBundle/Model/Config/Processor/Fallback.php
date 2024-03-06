<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Config\Processor;

use Doctrine\DBAL\Exception\TableNotFoundException;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use ProgramCms\WebsiteBundle\Model\Collection\Website\Collection as WebsiteCollection;
use ProgramCms\WebsiteBundle\Model\Collection\WebsiteView\Collection as WebsiteViewCollection;
use Exception;

/**
 * Class Fallback
 * @package ProgramCms\WebsiteBundle\Model\Config\Processor
 */
class Fallback
{
    /**
     * @var WebsiteCollection
     */
    protected WebsiteCollection $websiteCollection;

    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;

    /**
     * @var WebsiteViewCollection
     */
    protected WebsiteViewCollection $websiteViewCollection;

    /**
     * @var array
     */
    private array $websiteData;

    /**
     * @var array
     */
    private array $websiteViewData;

    /**
     * Fallback constructor.
     * @param WebsiteCollection $websiteCollection
     * @param WebsiteGroupRepository $websiteGroupRepository
     * @param WebsiteViewCollection $websiteViewCollection
     */
    public function __construct(
        WebsiteCollection $websiteCollection,
        WebsiteGroupRepository $websiteGroupRepository,
        WebsiteViewCollection $websiteViewCollection
    )
    {
        $this->websiteCollection = $websiteCollection;
        $this->websiteGroupRepository = $websiteGroupRepository;
        $this->websiteViewCollection = $websiteViewCollection;
    }

    /**
     * @param array $data
     * @return array
     */
    public function process(array $data)
    {
        $this->loadScopes();

        $defaultConfig = $data['default'] ?? [];
        $result = [
            'default' => $defaultConfig,
            'website' => [],
            'website_view' => []
        ];

        $websiteConfig = $data['website'] ?? [];
        $result['website'] = $this->prepareWebsitesConfig($defaultConfig, $websiteConfig);

        $websiteViewConfig = $data['website_view'] ?? [];
        $result['website_view'] = $this->prepareWebsiteViewsConfig($defaultConfig, $websiteConfig, $websiteViewConfig);

        return $result;
    }

    /**
     * Prepare website data
     * @param array $defaultConfig
     * @param array $websitesConfig
     * @return array
     */
    private function prepareWebsitesConfig(
        array $defaultConfig,
        array $websitesConfig
    ): array
    {
        $result = [];
        foreach ($this->websiteData as $website) {
            $code = $website['website_code'];
            $id = $website['website_id'];
            $websiteConfig = $websitesConfig[$code] ?? [];
            $result[$code] = array_replace_recursive($defaultConfig, $websiteConfig);
            $result[$id] = $result[$code];
        }
        return $result;
    }

    /**
     * Prepare websiteViews data
     * @param array $defaultConfig
     * @param array $websitesConfig
     * @param array $websiteViewsConfig
     * @return array
     */
    private function prepareWebsiteViewsConfig(
        array $defaultConfig,
        array $websitesConfig,
        array $websiteViewsConfig
    ): array
    {
        $result = [];

        foreach ($this->websiteViewData as $websiteView) {
            $code = $websiteView['website_view_code'];
            $id = $websiteView['website_view_id'];
            $websiteConfig = [];
            if (isset($websiteView['website_group_id'])) {
                $websiteConfig = $this->getWebsiteConfig(
                    $websitesConfig,
                    $this->getWebsiteId($websiteView['website_group_id'])
                );
            }
            $storeConfig = $websiteViewsConfig[$code] ?? [];
            $result[$code] = array_replace_recursive($defaultConfig, $websiteConfig, $storeConfig);
            $result[$id] = $result[$code];
        }
        return $result;
    }

    /**
     * @param array $websites
     * @param $id
     * @return array
     */
    private function getWebsiteConfig(array $websites, $id): array
    {
        foreach ($this->websiteData as $website) {
            if ($website['website_id'] == $id) {
                $code = $website['website_code'];
                return $websites[$code] ?? [];
            }
        }
        return [];
    }

    /**
     * Initialize scopes (websites and website views)
     * @return void
     */
    private function loadScopes()
    {
        try {
            $this->websiteData = $this->websiteCollection->getDataAsArray();
            /** @var WebsiteView $websiteView */
            foreach($this->websiteViewCollection->getData() as $websiteView) {
                $this->websiteViewData[] = [
                    'website_view_id' => $websiteView->getWebsiteViewId(),
                    'website_view_code' => $websiteView->getWebsiteViewCode(),
                    'website_view_name' => $websiteView->getWebsiteViewName(),
                    'website_group_id' => $websiteView->getWebsiteGroupId()
                ];
            }
        }catch(TableNotFoundException $e) {
            $this->websiteData = [];
            $this->websiteViewData = [];
        }
    }

    /**
     * @param $websiteGroupId
     * @return int|null
     */
    private function getWebsiteId($websiteGroupId)
    {
        try {
            $websiteGroup = $this->websiteGroupRepository->getById($websiteGroupId);
            return $websiteGroup->getWebsiteId();
        }catch(Exception $e) {
            return null;
        }
    }
}