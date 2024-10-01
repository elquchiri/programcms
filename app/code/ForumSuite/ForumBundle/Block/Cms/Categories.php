<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ForumSuite\ForumBundle\Block\Cms;

use Doctrine\Common\Collections\Collection;
use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\RouterBundle\Service\Url;
use ProgramCms\UserBundle\Entity\UserEntity;
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
     * @param CategoryEntity $category
     * @return int
     */
    public function countCategoryPosts(CategoryEntity $category): int
    {
        return $category->getPosts()->count();
    }


    /**
     * @param CategoryEntity $category
     * @return int
     */
    public function countCategoryComments(CategoryEntity $category): int
    {
        $count = 0;
        /** @var PostEntity $post */
        foreach($category->getPosts() as $post) {
            $count += $post->getComments()->count();
        }
        return $count;
    }

    /**
     * @param CategoryEntity $category
     * @return false
     */
    public function getLastComment(CategoryEntity $category)
    {
        foreach($category->getPosts() as $post) {
            if($post->getComments()->count()) {
                return $post->getComments()->last();
            }
        }
        return false;
    }

    /**
     * @param UserEntity $user
     * @return string
     */
    public function getUserUrl(UserEntity $user): string
    {
        return $this->getUrl('user_profile_view', ['id' => $user->getEntityId()]);
    }

    /**
     * @param CategoryEntity $category
     * @param PostEntity $post
     * @return string
     */
    public function getPostUrl(CategoryEntity $category, PostEntity $post): string
    {
        return $this->getUrl('post_index_view', ['category' => $category->getEntityId(), 'id' => $post->getEntityId()]);
    }
}