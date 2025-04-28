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

    /**
     * @var Breadcrumb
     */
    protected Breadcrumb $breadcrumb;

    /**
     * Config constructor.
     * @param Title $title
     * @param Breadcrumb $breadcrumb
     */
    public function __construct(
        Title $title,
        Breadcrumb $breadcrumb
    )
    {
        $this->title = $title;
        $this->breadcrumb = $breadcrumb;
    }
    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @return Breadcrumb
     */
    public function getBreadcrumb(): Breadcrumb
    {
        return $this->breadcrumb;
    }
}