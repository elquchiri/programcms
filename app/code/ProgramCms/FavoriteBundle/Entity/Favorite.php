<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\FavoriteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ProgramCms\CatalogBundle\Entity\CategoryEntity;
use ProgramCms\CoreBundle\Model\Db\Entity\Entity;
use ProgramCms\FavoriteBundle\Repository\FavoriteRepository;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\UserBundle\Entity\UserEntity;

/**
 * Class Favorite
 * @package ProgramCms\FavoriteBundle\Entity
 */
#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite extends Entity
{
    /**
     * @var UserEntity
     */
    #[ORM\ManyToOne(targetEntity: UserEntity::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'entity_id')]
    private UserEntity $user;

    /**
     * @var PostEntity
     */
    #[ORM\ManyToOne(targetEntity: PostEntity::class)]
    #[ORM\JoinColumn(name: 'post_id', referencedColumnName: 'entity_id')]
    private PostEntity $post;

    /**
     * @var CategoryEntity
     */
    #[ORM\ManyToOne(targetEntity: CategoryEntity::class)]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'entity_id')]
    private CategoryEntity $category;

    /**
     * @param UserEntity $user
     * @return $this
     */
    public function setUser(UserEntity $user): static
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }

    /**
     * @param PostEntity $post
     * @return $this
     */
    public function setPost(PostEntity $post): static
    {
        $this->post = $post;
        return $this;
    }

    /**
     * @return PostEntity
     */
    public function getPost(): PostEntity
    {
        return $this->post;
    }

    /**
     * @param CategoryEntity $category
     * @return $this
     */
    public function setCategory(CategoryEntity $category): static
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return CategoryEntity
     */
    public function getCategory(): CategoryEntity
    {
        return $this->category;
    }
}
