<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Website\Form;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\WebsiteBundle\Model\Collection\Website\Collection;
use ProgramCms\WebsiteBundle\Repository\WebsiteRepository;

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
     * @var WebsiteRepository
     */
    protected WebsiteRepository $websiteRepository;

    /**
     * DataProvider constructor.
     * @param Collection $collection
     * @param WebsiteRepository $websiteRepository
     * @param Request $request
     */
    public function __construct(
        Collection $collection,
        WebsiteRepository $websiteRepository,
        Request $request
    )
    {
        $this->collection = $collection;
        $this->request = $request;
        $this->websiteRepository = $websiteRepository;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        if(!empty($this->request->getParam('id'))) {
            $websiteId = $this->request->getParam('id');
            return $this->websiteRepository->findOneBy(['website_id' => $websiteId]);
        }

        return [];
    }
}