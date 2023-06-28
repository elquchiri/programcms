<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\CoreBundle\View\Page;

/**
 * Class Title
 * @package ProgramCms\CoreBundle\View\Page
 */
class Title
{
    /**
     * @var string
     */
    private string $title = "";

    /**
     * @param string $title
     * @return $this
     */
    public function set(string $title): static
    {
        $this->title = $title;
        return $this;
    }
    /**
     * @return string
     */
    public function get(): string
    {
        return $this->title;
    }
}