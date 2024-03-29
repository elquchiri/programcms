<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\WebsiteGroup\Form;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\WebsiteBundle\Entity\WebsiteGroup;
use ProgramCms\WebsiteBundle\Model\Collection\WebsiteGroup\Collection;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;

/**
 * Class DataProvider
 * @package ProgramCms\WebsiteBundle\Model\WebsiteGroup\Form
 */
class DataProvider extends \ProgramCms\UiBundle\DataProvider\AbstractDataProvider
{
    /**
     * @var Request
     */
    protected Request $request;
    /**
     * @var WebsiteGroupRepository
     */
    protected WebsiteGroupRepository $websiteGroupRepository;
    /**
     * @var ObjectManager
     */
    protected ObjectManager $objectManager;
    protected WebsiteRepository $websiteRepository;

    /**
     * DataProvider constructor.
     * @param Collection $collection
     * @param WebsiteGroupRepository $websiteGroupRepository
     * @param Request $request
     */
    public function __construct(
        Collection $collection,
        WebsiteGroupRepository $websiteGroupRepository,
        WebsiteRepository $websiteRepository,
        Request $request,
        ObjectManager $objectManager
    )
    {
        $this->collection = $collection;
        $this->request = $request;
        $this->websiteGroupRepository = $websiteGroupRepository;
        $this->objectManager = $objectManager;
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        if(!empty($this->request->getParam('id'))) {
            $websiteGroupId = $this->request->getParam('id');
            return $this->websiteGroupRepository->findOneBy(['website_group_id' => $websiteGroupId]);
        }
        else if(!empty($this->request->getParam('website_id'))) {
            $websiteId = $this->request->getParam('website_id');
            $websiteGroup = $this->objectManager->create(WebsiteGroup::class);
            $website = $this->websiteRepository->findOneBy(['website_id' => $websiteId]);
            $websiteGroup->setWebsite($website);
            return $websiteGroup;
        }

        return parent::getData();
    }
}