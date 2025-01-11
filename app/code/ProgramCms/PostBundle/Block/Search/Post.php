<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Block\Search;

use ProgramCms\CoreBundle\DateTime\TransformerInterface;
use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Model\Search\Post as PostModel;
use ProgramCms\UserBundle\Entity\UserEntity;

/**
 * Class Post
 * @package ProgramCms\PostBundle\Block\Search
 */
class Post extends Template
{
    /**
     * @var PostModel
     */
    protected PostModel $post;

    /**
     * @var TransformerInterface
     */
    protected TransformerInterface $transformer;

    /**
     * Post constructor.
     * @param Template\Context $context
     * @param TransformerInterface $transformer
     * @param PostModel $post
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        TransformerInterface $transformer,
        PostModel $post,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->post = $post;
        $this->transformer = $transformer;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        $filters = $this->getRequest()->getCurrentRequest()->query->all();
        return $this->post->getResults($filters);
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
     * @param PostEntity $post
     * @return string
     */
    public function getPostUpdatedAt(PostEntity $post): string
    {
        return $this->transformer->timeAgo($post->getUpdatedAt());
    }
}