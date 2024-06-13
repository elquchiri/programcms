<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;
use ProgramCms\PostBundle\Entity\PostEntity;
use ProgramCms\PostBundle\Repository\PostRepository;

/**
 * Class Post
 * @package ProgramCms\PostBundle\Block
 */
class Post extends Template
{
    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    /**
     * Post constructor.
     * @param Template\Context $context
     * @param PostRepository $postRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PostRepository $postRepository,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->postRepository = $postRepository;
    }

    /**
     * @return PostEntity|null
     */
    public function getPost(): ?PostEntity
    {
        $postId = $this->getRequest()->getParam('id');
        /** @var PostEntity $post */
        $post = $this->postRepository->getById($postId);
        if($post) {
            return $post;
        }
        return null;
    }
}