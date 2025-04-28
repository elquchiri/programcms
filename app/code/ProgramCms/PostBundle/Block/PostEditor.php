<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PostBundle\Block;

use ProgramCms\PageBundle\Block\PageEditor;

/**
 * Class PostEditor
 * @package ProgramCms\PostBundle\Block
 */
class PostEditor extends PageEditor
{
    /**
     * @return string
     */
    public function getLoadUrl(): string
    {
        return $this->getUrl('post_ajax_loadpost', [
            'post_id' => $this->getPostId()
        ]);
    }

    /**
     * @return string
     */
    public function getSaveUrl(): string
    {
        return $this->getUrl('post_index_save');
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->getRequest()->getParam('id');
    }
}