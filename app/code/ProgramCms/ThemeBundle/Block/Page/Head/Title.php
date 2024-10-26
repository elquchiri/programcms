<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\ThemeBundle\Block\Page\Head;

use ProgramCms\CoreBundle\View\Element\Template;

/**
 * Class Title
 * @package ProgramCms\ThemeBundle\Block\Page\Head
 */
class Title extends Template
{
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getLayout()->getTitle();
    }
}