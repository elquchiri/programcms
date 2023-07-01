<?php
/*
 * Copyright © ProgramCMS. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Developed by Mohamed EL QUCHIRI <elquchiri@gmail.com>
 */

namespace ProgramCms\AdminBundle\Block\Page;

/**
 * Class Copyright
 * @package ProgramCms\AdminBundle\Block\Page
 */
class Copyright extends \ProgramCms\CoreBundle\View\Element\Template
{
    /**
     * Returns current year for copyright
     * @return string
     */
    public function getCopyrightYear(): string
    {
        return date("Y");
    }
}