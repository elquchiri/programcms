<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\UserBundle\Ui\DataProvider;

use ProgramCms\CoreBundle\Model\Db\Collection\AbstractCollection;
use ProgramCms\UiBundle\DataProvider\FilterToCollectionInterface;
use ProgramCms\WebsiteBundle\Repository\WebsiteViewRepository;

/**
 * Class WebsiteViewFilter
 * @package ProgramCms\UserBundle\Ui\DataProvider
 */
class WebsiteViewFilter implements FilterToCollectionInterface
{
    /**
     * @var WebsiteViewRepository
     */
    protected WebsiteViewRepository $websiteViewRepository;

    /**
     * WebsiteViewFilter constructor.
     * @param WebsiteViewRepository $websiteViewRepository
     */
    public function __construct(
        WebsiteViewRepository $websiteViewRepository
    )
    {
        $this->websiteViewRepository = $websiteViewRepository;
    }

    /**
     * @param AbstractCollection $collection
     * @param $field
     * @param $value
     * @return mixed|void
     */
    public function addFilter(AbstractCollection $collection, $field, $value)
    {
        $websiteView = $this->websiteViewRepository->getById((int) $value);
        $collection->addFieldToFilter($field, $websiteView);
    }
}