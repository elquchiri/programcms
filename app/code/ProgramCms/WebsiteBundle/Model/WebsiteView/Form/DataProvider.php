<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\WebsiteView\Form;

use ProgramCms\CoreBundle\Model\ObjectManager;
use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\WebsiteBundle\Entity\WebsiteView;
use ProgramCms\WebsiteBundle\Model\Collection\WebsiteView\Collection;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class DataProvider
 * @package ProgramCms\WebsiteBundle\Model\WebsiteView\Form
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
    /**
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;

    /**
     * DataProvider constructor.
     * @param Collection $collection
     * @param WebsiteGroupRepository $websiteGroupRepository
     * @param WebsiteViewRepository $websiteViewRepository
     * @param Request $request
     * @param ObjectManager $objectManager
     */
    public function __construct(
        Collection $collection,
        WebsiteGroupRepository $websiteGroupRepository,
        WebsiteViewRepository $websiteViewRepository,
        Request $request,
        ObjectManager $objectManager
    )
    {
        $this->collection = $collection;
        $this->request = $request;
        $this->websiteGroupRepository = $websiteGroupRepository;
        $this->objectManager = $objectManager;
        $this->websiteViewRepository = $websiteViewRepository;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        if(!empty($this->request->getParam('id'))) {
            $websiteViewId = $this->request->getParam('id');
            return $this->websiteViewRepository->findOneBy(['website_view_id' => $websiteViewId]);
        }
        else if(!empty($this->request->getParam('website_group_id'))) {
            $websiteGroupId = $this->request->getParam('website_group_id');
            $websiteView = $this->objectManager->create(WebsiteView::class);
            $websiteGroup = $this->websiteGroupRepository->findOneBy(['website_group_id' => $websiteGroupId]);
            $websiteView->setWebsiteGroup($websiteGroup);
            return $websiteView;
        }

        return parent::getData();
    }
}