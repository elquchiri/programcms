<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ForumBundle\Block\Cms;

use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\WebsiteBundle\Model\WebsiteManagerInterface;

/**
 * Class Categories
 * @package ProgramCms\ForumBundle\Block\Cms
 */
class Categories extends Template
{
    /**
     * @var WebsiteManagerInterface
     */
    protected WebsiteManagerInterface $websiteManager;

    /**
     * Categories constructor.
     * @param Template\Context $context
     * @param WebsiteManagerInterface $websiteManager
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        WebsiteManagerInterface $websiteManager,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->websiteManager = $websiteManager;
    }

    public function getCategories()
    {
        $currentWebsiteView = $this->websiteManager->getWebsiteView();
        $category = $currentWebsiteView->getWebsiteGroup()->getCategory();
        return $category->getChildren();
    }

    public function getCategoryForums($category)
    {
        return $category->getChildren();
    }
}