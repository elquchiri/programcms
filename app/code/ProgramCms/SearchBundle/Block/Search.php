<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\SearchBundle\Block;

use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class Search
 * @package ProgramCms\SearchBundle\Block
 */
class Search extends Template
{
    /**
     * @return string
     */
    public function getSearchUrl(): string
    {
        return $this->getUrl('search_index_index');
    }
}