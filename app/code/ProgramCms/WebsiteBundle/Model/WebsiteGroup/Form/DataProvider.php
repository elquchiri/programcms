<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\WebsiteGroup\Form;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\WebsiteBundle\Model\Collection\WebsiteGroup\Collection;
use ProgramCms\WebsiteBundle\Repository\WebsiteGroupRepository;

/**
 * Class DataProvider
 * @package ProgramCms\WebsiteBundle\Model\Website\Form
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
     * DataProvider constructor.
     * @param Collection $collection
     * @param WebsiteGroupRepository $websiteGroupRepository
     * @param Request $request
     */
    public function __construct(
        Collection $collection,
        WebsiteGroupRepository $websiteGroupRepository,
        Request $request
    )
    {
        $this->collection = $collection;
        $this->request = $request;
        $this->websiteGroupRepository = $websiteGroupRepository;
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

        return parent::getData();
    }
}