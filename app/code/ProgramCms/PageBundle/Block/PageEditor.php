<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\PageBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class PageEditor
 * @package ProgramCms\PageBundle\Block
 */
class PageEditor extends Template
{
    /**
     * @return string
     */
    public function getLoadUrl(): string
    {
        return $this->getUrl('page_ajax_loadpage', [
            'page_id' => $this->getPageId()
        ]);
    }

    /**
     * @return string
     */
    public function getSaveUrl(): string
    {
        return $this->getUrl('page_index_save');
    }

    /**
     * @return mixed
     */
    public function getPageId()
    {
        return $this->getRequest()->getParam('page_id');
    }

    /**
     * @return string
     */
    public function getBackIcon(): string
    {
        return '/bundles/programcmspage/images/back.png';
    }
}