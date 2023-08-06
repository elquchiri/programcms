<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\WebsiteBundle\Model\Website\Form;

use ProgramCms\RouterBundle\Service\Request;
use ProgramCms\WebsiteBundle\Model\Collection\RootWebsite\Collection;
use ProgramCms\WebsiteBundle\Repository\WebsiteRootRepository;

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
     * @var WebsiteRootRepository
     */
    protected WebsiteRootRepository $websiteRootRepository;

    /**
     * DataProvider constructor.
     * @param Collection $collection
     * @param WebsiteRootRepository $websiteRootRepository
     * @param Request $request
     */
    public function __construct(
        Collection $collection,
        WebsiteRootRepository $websiteRootRepository,
        Request $request
    )
    {
        $this->collection = $collection;
        $this->request = $request;
        $this->websiteRootRepository = $websiteRootRepository;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        if(!empty($this->request->getParam('id'))) {
            $websiteRootId = $this->request->getParam('id');
            return $this->websiteRootRepository->findOneBy(['website_root_id' => $websiteRootId]);
        }

        return parent::getData();
    }
}