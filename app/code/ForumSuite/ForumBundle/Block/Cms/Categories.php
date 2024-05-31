<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ForumSuite\ForumBundle\Block\Cms;

use Doctrine\Common\Collections\Collection;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\RouterBundle\Service\Url;
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
     * @var Url
     */
    protected Url $url;

    /**
     * Categories constructor.
     * @param Template\Context $context
     * @param WebsiteManagerInterface $websiteManager
     * @param Url $url
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        WebsiteManagerInterface $websiteManager,
        Url $url,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->websiteManager = $websiteManager;
        $this->url = $url;
    }

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        $currentWebsiteView = $this->websiteManager->getWebsiteView();
        $category = $currentWebsiteView->getWebsiteGroup()->getCategory();
        return $category->getChildren();
    }

    /**
     * @param $category
     * @return mixed
     */
    public function getCategoryForums($category)
    {
        return $category->getChildren();
    }

    /**
     * @param $category
     * @return string
     */
    public function getForumUrl($category): string
    {
        return $this->url->getUrlByRouteName('catalog_category_view', ['id' => $category->getEntityId()]);
    }

    /**
     * @param $category
     * @return string
     */
    public function getCategoryImage($category): string
    {
        $finalX = 39;
        $finalY = 39;
        $finalImage = $this->url->getBaseUrl() . 'bundles/programcmstheme/images/logo.png';
        if(!empty($category->getCategoryImage())) {
            $finalImage = $category->getCategoryImage();
            if(file_exists($finalImage)) {
                $info = getimagesize($finalImage);
                list($x, $y) = $info;
                if ($x < 39 && $y < 39) {
                    $finalX = $x;
                    $finalY = $y;
                }
            }
        }
        return "<img src=\"{$finalImage}\" width=\"{$finalX}\" height=\"{$finalY}\" alt=\"\">";
    }

    /**
     * @return int
     */
    public function countCategoryPosts()
    {
        return rand(000, 999);
    }

    /**
     * @return int
     */
    public function countCategoryComments()
    {
        return rand(000, 999);
    }
}