<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Page;

/**
 * Class Config
 * @package ProgramCms\CoreBundle\View\Page
 */
class Config
{
    /**
     * @var Title
     */
    protected Title $title;

    public function __construct(
        Title $title
    )
    {
        $this->title = $title;
    }
    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }
}