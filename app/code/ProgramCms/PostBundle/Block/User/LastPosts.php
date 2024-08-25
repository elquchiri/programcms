<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Block\User;

use Doctrine\Common\Collections\Collection;
use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\UserBundle\Entity\UserEntity;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Common\Collections\Criteria;

/**
 * Class LastPosts
 * @package ProgramCms\PostBundle\Block\User
 */
class LastPosts extends Template
{
    /**
     * @var Security
     */
    protected Security $security;

    /**
     * LastPosts constructor.
     * @param Template\Context $context
     * @param Security $security
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Security $security,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->security = $security;
    }

    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        /** @var UserEntity $user */
        $user = $this->security->getUser();
        $criteria = Criteria::create()
            ->orderBy(['entity_id' => Criteria::DESC])
            ->setMaxResults(5);
        return $user->getPosts()->matching($criteria);
    }

    /**
     * @param PostEntity $post
     * @return string
     */
    public function getPostUrl(PostEntity $post): string
    {
        /** @var CategoryEntity $category */
        $category = $post->getCategories()->first();
        return $this->getUrl('post_index_view', [
            'id' => $post->getEntityId(),
            'category' => $category->getEntityId()
        ]);
    }
}